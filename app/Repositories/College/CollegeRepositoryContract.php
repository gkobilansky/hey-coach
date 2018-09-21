<?php
namespace App\Repositories\College;

interface CollegeRepositoryContract
{
    
    public function find($id);
    
    public function getAllColleges();

    public function listAllColleges();

    public function create($requestData);

    public function update($id, $requestData);

    public function destroy($request, $id);
}
