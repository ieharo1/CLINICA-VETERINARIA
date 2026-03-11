<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Mascota;
use App\Models\Consulta;
use App\Models\Vacuna;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $totalClientes = 0;
    public $totalMascotas = 0;
    public $consultasHoy = 0;
    public $vacunasPendientes = 0;
    public $mascotasPorEspecie = [];
    public $consultasRecientes = [];
    public $vacunasProximas = [];

    public function mount()
    {
        $this->totalClientes = Cliente::count();
        $this->totalMascotas = Mascota::count();
        
        $this->consultasHoy = Consulta::whereDate('fecha_consulta', today())->count();
        
        $this->vacunasPendientes = DB::table('vacunas_mascotas')
            ->whereNotNull('proxima_fecha')
            ->where('proxima_fecha', '<=', now()->addDays(30))
            ->count();

        $this->mascotasPorEspecie = Mascota::select('especie', DB::raw('count(*) as total'))
            ->groupBy('especie')
            ->get()
            ->toArray();

        $this->consultasRecientes = Consulta::with('mascota')
            ->orderBy('fecha_consulta', 'desc')
            ->limit(5)
            ->get()
            ->toArray();

        $this->vacunasProximas = DB::table('vacunas_mascotas')
            ->join('mascotas', 'vacunas_mascotas.mascota_id', '=', 'mascotas.id')
            ->join('vacunas', 'vacunas_mascotas.vacuna_id', '=', 'vacunas.id')
            ->select('mascotas.nombre as nombre_mascota', 'vacunas.nombre as nombre_vacuna', 'vacunas_mascotas.proxima_fecha')
            ->whereNotNull('vacunas_mascotas.proxima_fecha')
            ->where('vacunas_mascotas.proxima_fecha', '>=', today())
            ->where('vacunas_mascotas.proxima_fecha', '<=', now()->addDays(30))
            ->orderBy('vacunas_mascotas.proxima_fecha')
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
