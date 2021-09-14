<?php

namespace Database\Seeders;

use App\Models\MaintenanceType;
use Illuminate\Database\Seeder;

class MaintenanceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Preventive', 'description' => 'Preventive'],
            ['name' => 'Damage', 'description' => 'Damage'],
            ['name' => 'Corrective', 'description' => 'Corrective'],
            ['name' => 'Safety', 'description' => 'Safety'],
            ['name' => 'Upgrade', 'description' => 'Upgrade'],
            ['name' => 'Electrical', 'description' => 'Electrical'],
            ['name' => 'Project', 'description' => 'Project'],
            ['name' => 'Inspection', 'description' => 'Inspection'],
            ['name' => 'Meter reading', 'description' => 'Meter reading'],
            ['name' => 'Other', 'description' => 'Other'],
        ];

        foreach ($data as $maintenance_type) {
            MaintenanceType::create($maintenance_type);
        }
    }
}
