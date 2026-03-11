<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vacuna;
use App\Models\Mascota;
use Livewire\WithPagination;

class Vacunas extends Component
{
    use WithPagination;

    public $search = '';
    public $mostrarModal = false;
    public $mostrarModalAplicar = false;
    public $vacunaId;
    public $nombre, $descripcion, $dias_referencia, $es_obligatoria;
    public $vacunaSeleccionada;
    public $mascota_id, $fecha_aplicacion, $proxima_fecha, $lote, $observaciones;
    public $vacunasAplicadas = [];

    protected $rules = [
        'nombre' => 'required|min:2',
        'dias_referencia' => 'required|integer|min:1',
    ];

    public function render()
    {
        $vacunas = Vacuna::where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('nombre')
            ->paginate(10);

        $vacunasProximas = \DB::table('vacunas_mascotas')
            ->join('mascotas', 'vacunas_mascotas.mascota_id', '=', 'mascotas.id')
            ->join('vacunas', 'vacunas_mascotas.vacuna_id', '=', 'vacunas.id')
            ->select('mascotas.nombre as nombre_mascota', 'vacunas.nombre as nombre_vacuna', 'vacunas_mascotas.proxima_fecha', 'vacunas_mascotas.id')
            ->whereNotNull('vacunas_mascotas.proxima_fecha')
            ->where('vacunas_mascotas.proxima_fecha', '>=', today())
            ->where('vacunas_mascotas.proxima_fecha', '<=', now()->addDays(30))
            ->orderBy('vacunas_mascotas.proxima_fecha')
            ->limit(10)
            ->get();

        return view('livewire.vacunas', compact('vacunas', 'vacunasProximas'));
    }

    public function crearVacuna()
    {
        $this->limpiarCampos();
        $this->mostrarModal = true;
    }

    public function guardarVacuna()
    {
        $this->validate();

        Vacuna::updateOrCreate(['id' => $this->vacunaId], [
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'dias_referencia' => $this->dias_referencia,
            'es_obligatoria' => $this->es_obligatoria,
        ]);

        session()->flash('message', $this->vacunaId ? 'Vacuna actualizada exitosamente.' : 'Vacuna creada exitosamente.');
        $this->cerrarModal();
    }

    public function editarVacuna(Vacuna $vacuna)
    {
        $this->vacunaId = $vacuna->id;
        $this->nombre = $vacuna->nombre;
        $this->descripcion = $vacuna->descripcion;
        $this->dias_referencia = $vacuna->dias_referencia;
        $this->es_obligatoria = $vacuna->es_obligatoria;
        $this->mostrarModal = true;
    }

    public function eliminarVacuna(Vacuna $vacuna)
    {
        $vacuna->delete();
        session()->flash('message', 'Vacuna eliminada exitosamente.');
    }

    public function aplicarVacuna(Vacuna $vacuna)
    {
        $this->vacunaSeleccionada = $vacuna;
        $this->limpiarCamposAplicar();
        $this->mascotas = Mascota::with('cliente')->orderBy('nombre')->get();
        $this->mostrarModalAplicar = true;
    }

    public function guardarAplicacion()
    {
        $this->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'fecha_aplicacion' => 'required|date',
        ]);

        $mascota = Mascota::find($this->mascota_id);
        $proximaFecha = null;
        
        if ($this->fecha_aplicacion && $this->vacunaSeleccionada) {
            $proximaFecha = \Carbon\Carbon::parse($this->fecha_aplicacion)->addDays($this->vacunaSeleccionada->dias_referencia);
        }

        $mascota->vacunas()->attach($this->vacunaSeleccionada->id, [
            'fecha_aplicacion' => $this->fecha_aplicacion,
            'proxima_fecha' => $proximaFecha,
            'lote' => $this->lote,
            'observaciones' => $this->observaciones,
        ]);

        session()->flash('message', 'Vacuna aplicada exitosamente.');
        $this->cerrarModalAplicar();
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->limpiarCampos();
    }

    public function cerrarModalAplicar()
    {
        $this->mostrarModalAplicar = false;
        $this->limpiarCamposAplicar();
    }

    public function limpiarCampos()
    {
        $this->vacunaId = null;
        $this->nombre = '';
        $this->descripcion = '';
        $this->dias_referencia = 365;
        $this->es_obligatoria = false;
    }

    public function limpiarCamposAplicar()
    {
        $this->mascota_id = '';
        $this->fecha_aplicacion = '';
        $this->proxima_fecha = '';
        $this->lote = '';
        $this->observaciones = '';
    }
}
