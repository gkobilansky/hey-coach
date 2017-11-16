<?php
namespace App\Http\Controllers;

use Config;
use Dinero;
use Datatables;
use App\Models\Athlete;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\Athlete\StoreAthleteRequest;
use App\Http\Requests\Athlete\UpdateAthleteRequest;
use App\Repositories\User\UserRepositoryContract;
use App\Repositories\Athlete\AthleteRepositoryContract;
use App\Repositories\Setting\SettingRepositoryContract;

class AthletesController extends Controller
{

    protected $users;
    protected $athletes;
    protected $settings;

    public function __construct(
        UserRepositoryContract $users,
        AthleteRepositoryContract $athletes,
        SettingRepositoryContract $settings
    )
    {
        $this->users = $users;
        $this->athletes = $athletes;
        $this->settings = $settings;
        $this->middleware('athlete.create', ['only' => ['create']]);
        $this->middleware('athlete.update', ['only' => ['edit']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('athletes.index');
    }

    /**
     * Make json respnse for datatables
     * @return mixed
     */
    public function anyData()
    {
        $athletes = Athlete::select(['id', 'name', 'company_name', 'email', 'primary_number']);
        return Datatables::of($athletes)
            ->addColumn('namelink', function ($athletes) {
                return '<a href="athletes/' . $athletes->id . '" ">' . $athletes->name . '</a>';
            })
            ->add_column('edit', '
                <a href="{{ route(\'athletes.edit\', $id) }}" class="btn btn-success" >Edit</a>')
            ->add_column('delete', '
                <form action="{{ route(\'athletes.destroy\', $id) }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="submit" name="submit" value="Delete" class="btn btn-danger" onClick="return confirm(\'Are you sure?\')"">

            {{csrf_field()}}
            </form>')
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        return view('athletes.create')
            ->withUsers($this->users->getAllUsersWithDepartments())
            ->withIndustries($this->athletes->listAllIndustries());
    }

    /**
     * @param StoreAthleteRequest $request
     * @return mixed
     */
    public function store(StoreAthleteRequest $request)
    {
        $this->athletes->create($request->all());
        return redirect()->route('athletes.index');
    }

    /**
     * @param Request $vatRequest
     * @return mixed
     */
    public function cvrapiStart(Request $vatRequest)
    {
        return redirect()->back()
            ->with('data', $this->athletes->vat($vatRequest));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return mixed
     */
    public function show($id)
    {
        return view('athletes.show')
            ->withAthlete($this->athletes->find($id))
            ->withCompanyname($this->settings->getCompanyName())
            ->withInvoices($this->athletes->getInvoices($id))
            ->withUsers($this->users->getAllUsersWithDepartments());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return mixed
     */
    public function edit($id)
    {
        return view('athletes.edit')
            ->withAthlete($this->athletes->find($id))
            ->withUsers($this->users->getAllUsersWithDepartments())
            ->withIndustries($this->athletes->listAllIndustries());
    }

    /**
     * @param $id
     * @param UpdateAthleteRequest $request
     * @return mixed
     */
    public function update($id, UpdateAthleteRequest $request)
    {
        $this->athletes->update($id, $request);
        Session()->flash('flash_message', 'Athlete successfully updated');
        return redirect()->route('athletes.index');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $this->athletes->destroy($id);

        return redirect()->route('athletes.index');
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function updateAssign($id, Request $request)
    {
        $this->athletes->updateAssign($id, $request);
        Session()->flash('flash_message', 'New user is assigned');
        return redirect()->back();
    }

}
