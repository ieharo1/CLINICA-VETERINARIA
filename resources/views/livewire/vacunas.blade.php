@extends('layouts.app')

@section('title', 'Vacunas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="bi bi-shield-check"></i> Vacunas</h1>
            <button class="btn btn-primary" wire:click="crearVacuna">
                <i class="bi bi-plus-circle"></i> Nueva Vacuna
            </button>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <input type="text" class="form-control" placeholder="Buscar vacunas..." wire:model="search">
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card border-warning">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-bell"></i> Vacunas Próximas (30 días)</h5>
            </div>
            <div class="card-body">
                @if(count($vacunasProximas) > 0)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mascota</th>
                                <th>Vacuna</th>
                                <th>Próxima Fecha</th>
                                <th>Días Restantes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vacunasProximas as $item)
                            <tr>
                                <td>{{ $item->nombre_mascota }}</td>
                                <td>{{ $item->nombre_vacuna }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->proxima_fecha)->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $dias = \Carbon\Carbon::parse($item->proxima_fecha)->diffInDays(today());
                                    @endphp
                                    <span class="badge bg-{{ $dias <= 7 ? 'danger' : ($dias <= 14 ? 'warning' : 'info') }}">
                                        {{ $dias }} días
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted mb-0">No hay vacunas próximas en los próximos 30 días.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Días Referencia</th>
                        <th>Obligatoria</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vacunas as $vacuna)
                    <tr>
                        <td>{{ $vacuna->nombre }}</td>
                        <td>{{ $vacuna->descripcion }}</td>
                        <td>{{ $vacuna->dias_referencia }} días</td>
                        <td>
                            @if($vacuna->es_obligatoria)
                                <span class="badge bg-danger">Sí</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-success" wire:click="aplicarVacuna({{ $vacuna->id }})" title="Aplicar">
                                <i class="bi bi-plus-circle"></i> Aplicar
                            </button>
                            <button class="btn btn-sm btn-warning" wire:click="editarVacuna({{ $vacuna->id }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" wire:click="eliminarVacuna({{ $vacuna->id }})" onclick="return confirm('¿Está seguro de eliminar esta vacuna?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $vacunas->links() }}
    </div>
</div>

@if($mostrarModal)
<div class="modal fade show" style="display: block;" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $vacunaId ? 'Editar' : 'Nueva' }} Vacuna</h5>
                <button type="button" class="btn-close" wire:click="cerrarModal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre *</label>
                    <input type="text" class="form-control" wire:model="nombre">
                    @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" wire:model="descripcion" rows="2"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Días de Referencia *</label>
                        <input type="number" class="form-control" wire:model="dias_referencia">
                        @error('dias_referencia') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Obligatoria</label>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" wire:model="es_obligatoria" id="es_obligatoria">
                            <label class="form-check-label" for="es_obligatoria">Sí</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="cerrarModal">Cancelar</button>
                <button type="button" class="btn btn-primary" wire:click="guardarVacuna">Guardar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif

@if($mostrarModalAplicar)
<div class="modal fade show" style="display: block;" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aplicar Vacuna: {{ $vacunaSeleccionada->nombre }}</h5>
                <button type="button" class="btn-close" wire:click="cerrarModalAplicar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Mascota *</label>
                    <select class="form-select" wire:model="mascota_id">
                        <option value="">Seleccionar mascota</option>
                        @foreach($mascotas as $mascota)
                            <option value="{{ $mascota->id }}">{{ $mascota->nombre }} ({{ $mascota->cliente->nombre }} {{ $mascota->cliente->apellido }})</option>
                        @endforeach
                    </select>
                    @error('mascota_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha de Aplicación *</label>
                    <input type="date" class="form-control" wire:model="fecha_aplicacion">
                    @error('fecha_aplicacion') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Lote</label>
                    <input type="text" class="form-control" wire:model="lote">
                </div>
                <div class="mb-3">
                    <label class="form-label">Observaciones</label>
                    <textarea class="form-control" wire:model="observaciones" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="cerrarModalAplicar">Cancelar</button>
                <button type="button" class="btn btn-success" wire:click="guardarAplicacion">Aplicar Vacuna</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif
@endsection
