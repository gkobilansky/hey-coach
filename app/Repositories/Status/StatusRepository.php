<?php
namespace App\Repositories\Status;

use App\Models\Status;

/**
 * Class StatusRepository
 * @package App\Repositories\Status
 */
class StatusRepository implements StatusRepositoryContract
{

    /**
     * @return mixed
     */
    public function getAllStatuses()
    {
        
        $data = Status::select('id','name')->get()->toJson();
        return $data;
    }

    public function getStatusNames()
    {
        $names = Status::pluck('name','id');

        return $names;
    }
}
