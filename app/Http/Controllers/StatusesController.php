<?php
namespace App\Http\Controllers;

use Datatables;
use App\Models\Status;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\Status\StoreStatusRequest;
use App\Repositories\User\UserRepositoryContract;
use App\Repositories\Status\StatusRepositoryContract;

class statusesController extends Controller
{

    protected $statuses;

    /**
     * StatusesController constructor.
     * @param StatusRepositoryContract $statuses
     */
    public function __construct(StatusRepositoryContract $statuses)
    {
        $this->statuses = $statuses;
        $this->middleware('user.is.admin', ['only' => ['index', 'create', 'destroy']]);
    }


    /**
     * Make json respnse for datatables
     * @return mixed
     */
    public function data()
    {
        $statuses = Status::select(['id', 'name']);
        return Datatables::of($statuses)->make(true);
    }

    /**
     * @return mixed
     */
    // public function index()
    // {
    //     return view('statuses.index')
    //         ->withStatuses($this->statuses->allStatuses());
    // }

    /**
     * @return mixed
     */
    public function create()
    {
        return view('statuses.create');
    }

    /**
     * @param StoreStatusRequest $request
     * @return mixed
     */
    public function store(StoreStatusRequest $request)
    {
        $this->statuses->create($request);
        Session()->flash('flash_message', 'Status created');
        return redirect()->back();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $this->statuses->destroy($id);
        Session()->flash('flash_message', 'statuse deleted');
        return redirect()->route('statuses.index');
    }
}
