<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Mascota;
use App\Models\Cliente;
use App\Models\Raza;
use Livewire\WithPagination;

class Mascotas extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $mostrarModal = false;
    public $mostrarModalHistorial = false;
    public $mascotaId;
    public $cliente_id, $raza_id, $nombre, $especie, $genero, $fecha_nacimiento, $color, $peso, $foto, $notas, $esterilizado, $fecha_esterilizacion;
    public $mascotaSeleccionada;
    public $historialMedico = [];
    public $clientes = [];
    public $razas = [];

    protected $rules = [
        'cliente_id' => 'required|exists:clientes,id',
        'nombre' => 'required|min:2',
        'especie' => 'required',
        'genero' => 'required',
        'fecha_nacimiento' => 'required|date',
    ];

    public function mount()
    {
        $this->clientes = Cliente::orderBy('apellido')->orderBy('nombre')->get();
        $this->razas = Raza::orderBy('especie')->orderBy('nombre')->get();
    }

    public function render()
    {
        $mascotas = Mascota::with(['cliente', 'raza'])
            ->when($this->search, function ($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%')
                    ->orWhereHas('cliente', function ($q) {
                        $q->where('nombre', 'like', '%' . $this->search . '%')
                            ->orWhere('apellido', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('nombre')
            ->paginate(10);

        return view('livewire.mascotas', compact('mascotas'));
    }

    public function updatedEspecie()
    {
        $this->razas = Raza::where('especie', $this->especie)->orderBy('nombre')->get();
    }

    public function crearMascota()
    {
        $this->limpiarCampos();
        $this->mostrarModal = true;
    }

    public function guardarMascota()
    {
        $this->validate();

        $datos = [
            'cliente_id' => $this->cliente_id,
            'raza_id' => $this->raza_id,
            'nombre' => $this->nombre,
            'especie' => $this->especie,
            'genero' => $this->genero,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'color' => $this->color,
            'peso' => $this->peso,
            'notas' => $this->notas,
            'esterilizado' => $this->esterilizado,
            'fecha_esterilizacion' => $this->fecha_esterilizacion,
        ];

        if ($this->foto) {
            $datos['foto'] = $this->foto->store('mascotas', 'public');
        }

        Mascota::updateOrCreate(['id' => $this->mascotaId], $datos);

        session()->flash('message', $this->mascotaId ? 'Mascota actualizada exitosamente.' : 'Mascota creada exitosamente.');
        $this->cerrarModal();
    }

    public function editarMascota(Mascota $mascota)
    {
        $this->mascotaId = $mascota->id;
        $this->cliente_id = $mascota->cliente_id;
        $this->raza_id = $mascota->raza_id;
        $this->nombre = $mascota->nombre;
        $this->especie = $mascota->especie;
        $this->genero = $mascota->genero;
        $this->fecha_nacimiento = $mascota->fecha_nacimiento->format('Y-m-d');
        $this->color = $mascota->color;
        $this->peso = $mascota->peso;
        $this->notas = $mascota->notas;
        $this->esterilizado = $mascota->esterilizado;
        $this->fecha_esterilizacion = $mascota->fecha_esterilizacion?->format('Y-m-d');
        $this->mostrarModal = true;
    }

    public function verHistorial(Mascota $mascota)
    {
        $this->mascotaSeleccionada = $mascota->load(['consultas', 'cirugias', 'vacunas']);
        $this->historialMedico = [
            'consultas' => $mascota->consultas()->orderBy('fecha_consulta', 'desc')->get(),
            'cirugias' => $mascota->cirugias()->orderBy('fecha_cirugia', 'desc')->get(),
            'vacunas' => $mascota->vacunas()->orderBy('fecha_aplicacion', 'desc')->get(),
        ];
        $this->mostrarModalHistorial = true;
    }

    public function eliminarMascota(Mascota $mascota)
    {
        $mascota->delete();
        session()->flash('message', 'Mascota eliminada exitosamente.');
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->limpiarCampos();
    }

    public function cerrarModalHistorial()
    {
        $this->mostrarModalHistorial = false;
        $this->mascotaSeleccionada = null;
    }

    public function limpiarCampos()
    {
        $this->mascotaId = null;
        $this->cliente_id = '';
        $this->raza_id = '';
        $this->nombre = '';
        $this->especie = '';
        $this->genero = '';
        $this->fecha_nacimiento = '';
        $this->color = '';
        $this->peso = '';
        $this->foto = null;
        $this->notas = '';
        $this->esterilizado = false;
        $this->fecha_esterilizacion = '';
    }
}
