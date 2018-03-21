<?php
namespace App\Repositories\Recruit;

interface RecruitRepositoryContract
{
    public function find($id);
    
    public function create($requestData);

    public function updateStatus($id, $status_id, $requestData);

    public function updateFollowup($id, $requestData);

    public function updateAssign($id, $requestData);

    public function recruits();

    public function allCompletedRecruits();

    public function percantageCompleted();

    public function completedRecruitsToday();

    public function createdRecruitsToday();

    public function completedRecruitsThisMonth();

    public function createdRecruitsMonthly();

    public function completedRecruitsMonthly();

    public function totalOpenAndClosedRecruits($id);
}
