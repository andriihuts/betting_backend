<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hospital;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hospitals = [
            'Military Hospital',
            'Mount Lebanon Hospital',
            'Clemenceau Medical Center',
        ];

        foreach ($hospitals as $hospital) {
            Hospital::firstOrCreate(['hospital_name' => $hospital]);
        }
    }
}
