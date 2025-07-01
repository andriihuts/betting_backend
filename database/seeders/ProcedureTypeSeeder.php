<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProcedureType;

class ProcedureTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'TTE',
            'TEE',
            'Cath',
            'PCI',
            'Right Heart Cath',
            'Stress Echo',
            'Dobutamine Stress test',
            'TAVI',
            'Mitral Clip',
            'ASD/PFO closure',
            'Pericardiocentesis',
        ];

        foreach ($types as $type) {
            ProcedureType::firstOrCreate(['procedure_type' => $type]);
        }
    }
}
