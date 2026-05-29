<?php

namespace Database\Seeders;

use App\Models\Carpeta;
use App\Models\Semestre;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@institucion.edu'],
            ['name' => 'Administrador', 'password' => Hash::make('password')]
        );

        $admin->assignRole('Administrador');

        $semestres = [
            ['nombre' => 'Primer Semestre', 'anio' => 2026],
            ['nombre' => 'Segundo Semestre', 'anio' => 2026],
        ];

        foreach ($semestres as $data) {
            $semestre = Semestre::firstOrCreate($data, ['activo' => true]);

            foreach (['Planificaciones', 'Informes', 'Evidencias'] as $nombreCarpeta) {
                Carpeta::firstOrCreate([
                    'semestre_id' => $semestre->id,
                    'parent_id' => null,
                    'nombre' => $nombreCarpeta,
                ]);
            }
        }
    }
}
