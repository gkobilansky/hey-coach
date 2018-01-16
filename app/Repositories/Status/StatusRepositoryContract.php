<?php
namespace App\Repositories\Status;

interface StatusRepositoryContract
{
    public function getAllStatuses();
    public function getStatusNames();
    
}
