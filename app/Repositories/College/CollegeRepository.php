<?php
namespace App\Repositories\College;

use App\Models\College;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Log;


/**
 * Class CollegeRepository
 * @package App\Repositories\College
 */
class CollegeRepository implements CollegeRepositoryContract
{

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return College::findOrFail($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllColleges()
    {
        return College::all();
    }

    /**
     * @return mixed
     */
    public function listAllColleges()
    {
        return College::pluck('name', 'id');
    }

    /**
     * @param $requestData
     * @return static
     */
    public function create($requestData)
    {

        $college = College::create($requestData);
        Session()->flash('flash_message', 'College successfully added');
        return $college;
    }

    /**
     * @param $id
     * @param $requestData
     * @return mixed
     */
    public function update($id, $requestData)
    {
        $college = College::findOrFail($id);
        $college->fill($requestData->all())->save();

        Session::flash('flash_message', 'College successfully updated!');

        return $college;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($request, $id)
    {
        
        try {
            $college = College::findorFail($id);
            $college->delete();
            Session()->flash('flash_message', 'College successfully deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            Session()->flash('flash_message_warning', 'College can NOT have, users, or recruits assigned when deleted');
        }
    }
}
