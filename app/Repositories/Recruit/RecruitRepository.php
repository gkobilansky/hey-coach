<?php
namespace App\Repositories\Recruit;

use App\Models\Recruit;
use Notifynder;
use Carbon;
use DB;

/**
 * Class RecruitRepository
 * @package App\Repositories\Recruit
 */
class RecruitRepository implements RecruitRepositoryContract
{
    /**
     *
     */
    const CREATED = 'created';
    /**
     *
     */
    const UPDATED_STATUS = 'updated_status';
    /**
     *
     */
    const UPDATED_DEADLINE = 'updated_deadline';
    /**
     *
     */
    const UPDATED_ASSIGN = 'updated_assign';

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return Recruit::findOrFail($id);
    }

    /**
     * @param $requestData
     * @return mixed
     */
    public function create($requestData)
    {
        $athlete_id = $requestData->get('athlete_id');
        $input = $requestData = array_merge(
            $requestData->all(),
            ['user_created_id' => \Auth::id(),
                'contact_date' => $requestData->contact_date . " " . $requestData->contact_time . ":00"]
        );

        $recruit = Recruit::create($input);
        $insertedId = $recruit->id;
        Session()->flash('flash_message', 'Recruit successfully added!');

        event(new \App\Events\RecruitAction($recruit, self::CREATED));

        return $insertedId;
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function updateStatus($id, $requestData)
    {
        $recruit = Recruit::findOrFail($id);

//        $input = $requestData->get('status');
        $input = array_replace($requestData->all(), ['status_id' => 2]);
        $recruit->fill($input)->save();
        event(new \App\Events\RecruitAction($recruit, self::UPDATED_STATUS));
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function updateFollowup($id, $requestData)
    {
        $recruit = Recruit::findOrFail($id);
        $input = $requestData->all();
        $input = $requestData =
            ['contact_date' => $requestData->contact_date . " " . $requestData->contact_time . ":00"];
        $recruit->fill($input)->save();
        event(new \App\Events\RecruitAction($recruit, self::UPDATED_DEADLINE));
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function updateAssign($id, $requestData)
    {
        $recruit = Recruit::findOrFail($id);

        $input = $requestData->get('user_assigned_id');
        $input = array_replace($requestData->all());
        $recruit->fill($input)->save();
        $insertedName = $recruit->user->name;

        event(new \App\Events\RecruitAction($recruit, self::UPDATED_ASSIGN));
    }

    /**
     * @return int
     */
    public function recruits()
    {
        return Recruit::all()->count();
    }

    /**
     * @return mixed
     */
    public function allCompletedRecruits()
    {
        return Recruit::where('status_id', 2)->count();
    }

    /**
     * @return float|int
     */
    public function percantageCompleted()
    {
        if (!$this->recruits() || !$this->allCompletedRecruits()) {
            $totalPercentageRecruits = 0;
        } else {
            $totalPercentageRecruits = $this->allCompletedRecruits() / $this->recruits() * 100;
        }

        return $totalPercentageRecruits;
    }

    /**
     * @return mixed
     */
    public function completedRecruitsToday()
    {
        return Recruit::whereRaw(
            'date(updated_at) = ?',
            [Carbon::now()->format('Y-m-d')]
        )->where('status_id', 2)->count();
    }

    /**
     * @return mixed
     */
    public function createdRecruitsToday()
    {
        return Recruit::whereRaw(
            'date(created_at) = ?',
            [Carbon::now()->format('Y-m-d')]
        )->count();
    }

    /**
     * @return mixed
     */
    public function completedRecruitsThisMonth()
    {
        return DB::table('recruits')
            ->select(DB::raw('count(*) as total, updated_at'))
            ->where('status_id', 2)
            ->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()])->get();
    }

    /**
     * @return mixed
     */
    public function createdRecruitsMonthly()
    {
        return DB::table('recruits')
            ->select(DB::raw('count(*) as month, updated_at'))
            ->where('status_id', 2)
            ->groupBy(DB::raw('YEAR(updated_at), MONTH(updated_at)'))
            ->get();
    }

    /**
     * @return mixed
     */
    public function completedRecruitsMonthly()
    {
        return DB::table('recruits')
            ->select(DB::raw('count(*) as month, created_at'))
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function totalOpenAndClosedRecruits($id)
    {
        $open_recruits = Recruit::where('status_id', 1)
        ->where('user_assigned_id', $id)
        ->count();

        $closed_recruits = Recruit::where('status_id', 2)
        ->where('user_assigned_id', $id)->count();

        return collect([$closed_recruits, $open_recruits]);
    }
}
