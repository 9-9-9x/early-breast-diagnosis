<?php

namespace Database\Seeders;

use App\Models\DashboardTarget;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DashboardTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DashboardTarget::create([
            'name' => 'Ca Mamae',
            'sasaran' => 6509,
            'target' => 5858,
            'tahun' => date('Y'),
        ]);
    }
}
