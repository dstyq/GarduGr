<?php

namespace Database\Seeders;

use App\Models\WorkOrderStatus;
use Illuminate\Database\Seeder;

class WorkOrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'On Hold', 'status' => 'pending'],
            ['name' => 'Draft', 'status' => 'draft'],
            ['name' => 'Open', 'status' => 'active'],
            ['name' => 'Complete', 'status' => 'closed']
        ];

        foreach ($data as $wo_status) {
            WorkOrderStatus::create($wo_status);
        }
    }
}
