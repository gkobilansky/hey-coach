<?php

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $interestedStatus = new Status;
        $interestedStatus->name = 'Interested';
        $interestedStatus->save();

        $appliedStatus = new Status;
        $appliedStatus->name = 'Applied ED1';
        $appliedStatus->save();

        $acceptedStatus = new Status;
        $acceptedStatus->name = 'Applied ED2';
        $acceptedStatus->save();

        $acceptedStatus = new Status;
        $acceptedStatus->name = 'Applied';
        $acceptedStatus->save();

        $acceptedStatus = new Status;
        $acceptedStatus->name = 'Accepted';
        $acceptedStatus->save();

        $rejectedStatus = new Status;
        $rejectedStatus->name = 'Rejected';
        $rejectedStatus->save();
    }
}
