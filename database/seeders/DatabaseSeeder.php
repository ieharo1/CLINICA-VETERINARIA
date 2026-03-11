<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Mascota;
use App\Models\Raza;
use App\Models\Vacuna;
use App\Models\Consulta;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Veterinario',
            'email' => 'admin@veterinaria.com',
        ]);

        $cliente1 = Cliente::create([
            'nombre' => 'Juan Pérez',
            'cedula' => '1712345678',
            'telefono' => '0991234567',
            'email' => 'juan.perez@email.com',
            'direccion' => 'Av. Principal 123',
        ]);

        $cliente2 = Cliente::create([
            'nombre' => 'María García',
            'cedula' => '1723456789',
            'telefono' => '0982345678',
            'email' => 'maria.garcia@email.com',
            'direccion' => 'Calle Secundaria 456',
        ]);

        $razaPerro = Raza::create([
            'nombre' => 'Labrador',
            'especie' => 'perro',
        ]);

        $razaGato = Raza::create([
            'nombre' => 'Persa',
            'especie' => 'gato',
        ]);

        $mascota1 = Mascota::create([
            'nombre' => 'Max',
            'especie' => 'perro',
            'raza_id' => $razaPerro->id,
            'edad' => 3,
            'peso' => 25.5,
            'color' => 'Dorada',
            'cliente_id' => $cliente1->id,
        ]);

        $mascota2 = Mascota::create([
            'nombre' => 'Luna',
            'especie' => 'gato',
            'raza_id' => $razaGato->id,
            'edad' => 2,
            'peso' => 4.2,
            'color' => 'Blanca',
            'cliente_id' => $cliente2->id,
        ]);

        $mascota3 = Mascota::create([
            'nombre' => 'Buddy',
            'especie' => 'perro',
            'raza_id' => $razaPerro->id,
            'edad' => 5,
            'peso' => 30.0,
            'color' => 'Marrón',
            'cliente_id' => $cliente1->id,
        ]);

        Vacuna::create([
            'mascota_id' => $mascota1->id,
            'nombre' => 'Rabia',
            'fecha_aplicacion' => '2025-01-15',
            'proxima_fecha' => '2026-01-15',
            'veterinario' => 'Dr. Smith',
        ]);

        Vacuna::create([
            'mascota_id' => $mascota1->id,
            'nombre' => 'Moquillo',
            'fecha_aplicacion' => '2025-02-20',
            'proxima_fecha' => '2026-02-20',
            'veterinario' => 'Dr. Smith',
        ]);

        Vacuna::create([
            'mascota_id' => $mascota2->id,
            'nombre' => 'Triple Felina',
            'fecha_aplicacion' => '2025-03-10',
            'proxima_fecha' => '2026-03-10',
            'veterinario' => 'Dr. Johnson',
        ]);

        Vacuna::create([
            'mascota_id' => $mascota3->id,
            'nombre' => 'Rabia',
            'fecha_aplicacion' => '2025-01-05',
            'proxima_fecha' => '2025-07-05',
            'veterinario' => 'Dr. Smith',
            'notas' => 'Recordatorio: necesita refuerzo pronto',
        ]);

        Consulta::create([
            'mascota_id' => $mascota1->id,
            'fecha' => '2025-03-01',
            'motivo' => 'Revisión general',
            'diagnostico' => 'Salud buena',
            'tratamiento' => 'Vitaminas',
            'veterinario' => 'Dr. Smith',
        ]);

        Consulta::create([
            'mascota_id' => $mascota2->id,
            'fecha' => '2025-03-05',
            'motivo' => 'Vacunación',
            'diagnostico' => 'Salud excelente',
            'tratamiento' => 'Ninguno',
            'veterinario' => 'Dr. Johnson',
        ]);
    }
}
