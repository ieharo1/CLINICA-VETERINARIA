<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cliente;
use Livewire\WithPagination;

class Clientes extends Component
{
    use WithPagination;

    public $search = '';
    public $mostrarModal = false;
    public $clienteId;
    public $nombre, $apellido, $telefono, $email, $direccion, $ciudad, $notas;

    protected $rules = [
        'nombre' => 'required|min:2',
        'apellido' => 'required|min:2',
        'telefono' => 'required',
        'email' => 'required|email|unique:clientes,email',
    ];

    public function render()
    {
        $clientes = Cliente::where('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('apellido', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('telefono', 'like', '%' . $this->search . '%')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(10);

        return view('livewire.clientes', compact('clientes'));
    }

    public function crearCliente()
    {
        $this->limpiarCampos();
        $this->mostrarModal = true;
    }

    public function guardarCliente()
    {
        $this->validate();

        Cliente::updateOrCreate(['id' => $this->clienteId], [
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'direccion' => $this->direccion,
            'ciudad' => $this->ciudad,
            'notas' => $this->notas,
        ]);

        session()->flash('message', $this->clienteId ? 'Cliente actualizado exitosamente.' : 'Cliente creado exitosamente.');
        $this->cerrarModal();
    }

    public function editarCliente(Cliente $cliente)
    {
        $this->clienteId = $cliente->id;
        $this->nombre = $cliente->nombre;
        $this->apellido = $cliente->apellido;
        $this->telefono = $cliente->telefono;
        $this->email = $cliente->email;
        $this->direccion = $cliente->direccion;
        $this->ciudad = $cliente->ciudad;
        $this->notas = $cliente->notas;
        $this->mostrarModal = true;
    }

    public function eliminarCliente(Cliente $cliente)
    {
        $cliente->delete();
        session()->flash('message', 'Cliente eliminado exitosamente.');
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->limpiarCampos();
    }

    public function limpiarCampos()
    {
        $this->clienteId = null;
        $this->nombre = '';
        $this->apellido = '';
        $this->telefono = '';
        $this->email = '';
        $this->direccion = '';
        $this->ciudad = '';
        $this->notas = '';
    }
}
