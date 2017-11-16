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
        $interestedStatus->name = 'interested';
        $interestedStatus->save();

        $appliedStatus = new Status;
        $appliedStatus->name = 'applied';
        $appliedStatus->save();

        $acceptedStatus = new Status;
        $acceptedStatus->name = 'accepted';
        $acceptedStatus->save();

        $rejectedStatus = new Status;
        $rejectedStatus->name = 'rejected';
        $rejectedStatus->save();
    }
}
