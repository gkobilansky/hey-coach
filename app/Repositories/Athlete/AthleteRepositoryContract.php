<?php
namespace App\Repositories\Athlete;

interface AthleteRepositoryContract
{
    public function find($id);

    public function listAllAthletes();

    public function getInvoices($id);

    public function getAllAthletesCount();

    public function listAllIndustries();

    public function create($requestData);

    public function update($id, $requestData);

    public function destroy($id);

    public function vat($requestData);
}
