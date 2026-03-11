<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Consulta;
use App\Models\Mascota;
use App\Models\Tratamiento;
use Livewire\WithPagination;

class Consultas extends Component
{
    use WithPagination;

    public $search = '';
    public $mostrarModal = false;
    public $mostrarModalTratamiento = false;
    public $consultaId;
    public $mascota_id, $fecha_consulta, $motivo, $sintomas, $diagnostico, $tratamiento, $peso_actual, $temperatura, $frecuencia_cardiaca, $frecuencia_respiratoria, $observaciones, $estado;
    public $consultaSeleccionada;
    public $tratamientos = [];
    public $mascotas = [];

    protected $rules = [
        'mascota_id' => 'required|exists:mascotas,id',
        'fecha_consulta' => 'required|date',
        'motivo' => 'required',
    ];

    public function mount()
    {
        $this->mascotas = Mascota::with('cliente')->orderBy('nombre')->get();
    }

    public function render()
    {
        $consultas = Consulta::with(['mascota', 'mascota.cliente'])
            ->when($this->search, function ($query) {
                $query->where('motivo', 'like', '%' . $this->search . '%')
                    ->orWhereHas('mascota', function ($q) {
                        $q->where('nombre', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('fecha_consulta', 'desc')
            ->paginate(10);

        return view('livewire.consultas', compact('consultas'));
    }

    public function crearConsulta()
    {
        $this->limpiarCampos();
        $this->mostrarModal = true;
    }

    public function guardarConsulta()
    {
        $this->validate();

        Consulta::updateOrCreate(['id' => $this->consultaId], [
            'mascota_id' => $this->mascota_id,
            'fecha_consulta' => $this->fecha_consulta,
            'motivo' => $this->motivo,
            'sintomas' => $this->sintomas,
            'diagnostico' => $this->diagnostico,
            'tratamiento' => $this->tratamiento,
            'peso_actual' => $this->peso_actual,
            'temperatura' => $this->temperatura,
            'frecuencia_cardiaca' => $this->frecuencia_cardiaca,
            'frecuencia_respiratoria' => $this->frecuencia_respiratoria,
            'observaciones' => $this->observaciones,
            'estado' => $this->estado ?? 'pendiente',
        ]);

        session()->flash('message', $this->consultaId ? 'Consulta actualizada exitosamente.' : 'Consulta creada exitosamente.');
        $this->cerrarModal();
    }

    public function editarConsulta(Consulta $consulta)
    {
        $this->consultaId = $consulta->id;
        $this->mascota_id = $consulta->mascota_id;
        $this->fecha_consulta = $consulta->fecha_consulta->format('Y-m-d\TH:i');
        $this->motivo = $consulta->motivo;
        $this->sintomas = $consulta->sintomas;
        $this->diagnostico = $consulta->diagnostico;
        $this->tratamiento = $consulta->tratamiento;
        $this->peso_actual = $consulta->peso_actual;
        $this->temperatura = $consulta->temperatura;
        $this->frecuencia_cardiaca = $consulta->frecuencia_cardiaca;
        $this->frecuencia_respiratoria = $consulta->frecuencia_respiratoria;
        $this->observaciones = $consulta->observaciones;
        $this->estado = $consulta->estado;
        $this->mostrarModal = true;
    }

    public function verTratamientos(Consulta $consulta)
    {
        $this->consultaSeleccionada = $consulta->load('tratamientos');
        $this->mostrarModalTratamiento = true;
    }

    public function agregarTratamiento()
    {
        $this->validate([
            'tratamientos.*.nombre' => 'required',
        ]);

        foreach ($this->tratamientos as $tratamientoData) {
            if (!empty($tratamientoData['nombre'])) {
                Tratamiento::create([
                    'consulta_id' => $this->consultaSeleccionada->id,
                    'nombre' => $tratamientoData['nombre'],
                    'medicamento' => $tratamientoData['medicamento'] ?? null,
                    'dosis' => $tratamientoData['dosis'] ?? null,
                    'frecuencia' => $tratamientoData['frecuencia'] ?? null,
                    'duracion_dias' => $tratamientoData['duracion_dias'] ?? null,
                    'fecha_inicio' => $tratamientoData['fecha_inicio'] ?? null,
                    'observaciones' => $tratamientoData['observaciones'] ?? null,
                    'estado' => 'activo',
                ]);
            }
        }

        $this->consultaSeleccionada->load('tratamientos');
        $this->tratamientos = [];
        session()->flash('message', 'Tratamiento(s) agregado(s) exitosamente.');
    }

    public function eliminarConsulta(Consulta $consulta)
    {
        $consulta->delete();
        session()->flash('message', 'Consulta eliminada exitosamente.');
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->limpiarCampos();
    }

    public function cerrarModalTratamiento()
    {
        $this->mostrarModalTratamiento = false;
        $this->consultaSeleccionada = null;
    }

    public function limpiarCampos()
    {
        $this->consultaId = null;
        $this->mascota_id = '';
        $this->fecha_consulta = '';
        $this->motivo = '';
        $this->sintomas = '';
        $this->diagnostico = '';
        $this->tratamiento = '';
        $this->peso_actual = '';
        $this->temperatura = '';
        $this->frecuencia_cardiaca = '';
        $this->frecuencia_respiratoria = '';
        $this->observaciones = '';
        $this->estado = 'pendiente';
    }

    public function agregarCampoTratamiento()
    {
        $this->tratamientos[] = [
            'nombre' => '',
            'medicamento' => '',
            'dosis' => '',
            'frecuencia' => '',
            'duracion_dias' => '',
            'fecha_inicio' => '',
            'observaciones' => '',
        ];
    }

    public function quitarCampoTratamiento($index)
    {
        unset($this->tratamientos[$index]);
        $this->tratamientos = array_values($this->tratamientos);
    }
}
