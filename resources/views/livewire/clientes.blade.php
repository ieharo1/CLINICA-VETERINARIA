@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="bi bi-people"></i> Clientes</h1>
            <button class="btn btn-primary" wire:click="crearCliente">
                <i class="bi bi-plus-circle"></i> Nuevo Cliente
            </button>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" class="form-control" placeholder="Buscar clientes..." wire:model="search">
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Ciudad</th>
                        <th>Mascotas</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->nombre }} {{ $cliente->apellido }}</td>
                        <td>{{ $cliente->telefono }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ $cliente->ciudad }}</td>
                        <td>
                            <span class="badge bg-info">{{ $cliente->mascotas->count() }}</span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-warning" wire:click="editarCliente({{ $cliente->id }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" wire:click="eliminarCliente({{ $cliente->id }})" onclick="return confirm('¿Está seguro de eliminar este cliente?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $clientes->links() }}
    </div>
</div>

@if($mostrarModal)
<div class="modal fade show" style="display: block;" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $clienteId ? 'Editar' : 'Nuevo' }} Cliente</h5>
                <button type="button" class="btn-close" wire:click="cerrarModal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" class="form-control" wire:model="nombre">
                        @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Apellido *</label>
                        <input type="text" class="form-control" wire:model="apellido">
                        @error('apellido') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono *</label>
                        <input type="text" class="form-control" wire:model="telefono">
                        @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" wire:model="email">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dirección</label>
                        <input type="text" class="form-control" wire:model="direccion">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ciudad</label>
                        <input type="text" class="form-control" wire:model="ciudad">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notas</label>
                    <textarea class="form-control" wire:model="notas" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="cerrarModal">Cancelar</button>
                <button type="button" class="btn btn-primary" wire:click="guardarCliente">Guardar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif
@endsection
