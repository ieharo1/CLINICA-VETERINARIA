@extends('layouts.app')

@section('title', 'Consultas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="bi bi-clipboard-pulse"></i> Consultas</h1>
            <button class="btn btn-primary" wire:click="crearConsulta">
                <i class="bi bi-plus-circle"></i> Nueva Consulta
            </button>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" class="form-control" placeholder="Buscar consultas..." wire:model="search">
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Mascota</th>
                        <th>Dueño</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consultas as $consulta)
                    <tr>
                        <td>{{ $consulta->fecha_consulta->format('d/m/Y H:i') }}</td>
                        <td>{{ $consulta->mascota->nombre }}</td>
                        <td>{{ $consulta->mascota->cliente->nombre }} {{ $consulta->mascota->cliente->apellido }}</td>
                        <td>{{ $consulta->motivo }}</td>
                        <td>
                            @switch($consulta->estado)
                                @case('pendiente')
                                    <span class="badge bg-warning">Pendiente</span>
                                    @break
                                @case('en_progreso')
                                    <span class="badge bg-info">En Progreso</span>
                                    @break
                                @case('completada')
                                    <span class="badge bg-success">Completada</span>
                                    @break
                                @case('cancelada')
                                    <span class="badge bg-danger">Cancelada</span>
                                    @break
                            @endswitch
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-info" wire:click="verTratamientos({{ $consulta->id }})" title="Tratamientos">
                                <i class="bi bi-capsule"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" wire:click="editarConsulta({{ $consulta->id }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" wire:click="eliminarConsulta({{ $consulta->id }})" onclick="return confirm('¿Está seguro de eliminar esta consulta?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $consultas->links() }}
    </div>
</div>

@if($mostrarModal)
<div class="modal fade show" style="display: block;" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $consultaId ? 'Editar' : 'Nueva' }} Consulta</h5>
                <button type="button" class="btn-close" wire:click="cerrarModal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mascota *</label>
                        <select class="form-select" wire:model="mascota_id">
                            <option value="">Seleccionar mascota</option>
                            @foreach($mascotas as $mascota)
                                <option value="{{ $mascota->id }}">{{ $mascota->nombre }} ({{ $mascota->cliente->nombre }})</option>
                            @endforeach
                        </select>
                        @error('mascota_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fecha y Hora *</label>
                        <input type="datetime-local" class="form-control" wire:model="fecha_consulta">
                        @error('fecha_consulta') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Motivo *</label>
                        <input type="text" class="form-control" wire:model="motivo">
                        @error('motivo') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" wire:model="estado">
                            <option value="pendiente">Pendiente</option>
                            <option value="en_progreso">En Progreso</option>
                            <option value="completada">Completada</option>
                            <option value="cancelada">Cancelada</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Peso (kg)</label>
                        <input type="text" class="form-control" wire:model="peso_actual">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Temperatura (°C)</label>
                        <input type="text" class="form-control" wire:model="temperatura">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Frec. Cardíaca</label>
                        <input type="text" class="form-control" wire:model="frecuencia_cardiaca">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Síntomas</label>
                    <textarea class="form-control" wire:model="sintomas" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Diagnóstico</label>
                    <textarea class="form-control" wire:model="diagnostico" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tratamiento</label>
                    <textarea class="form-control" wire:model="tratamiento" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Observaciones</label>
                    <textarea class="form-control" wire:model="observaciones" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="cerrarModal">Cancelar</button>
                <button type="button" class="btn btn-primary" wire:click="guardarConsulta">Guardar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif

@if($mostrarModalTratamiento && $consultaSeleccionada)
<div class="modal fade show" style="display: block;" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tratamientos - Consulta del {{ $consultaSeleccionada->fecha_consulta->format('d/m/Y') }}</h5>
                <button type="button" class="btn-close" wire:click="cerrarModalTratamiento"></button>
            </div>
            <div class="modal-body">
                <h6>Tratamientos Existentes</h6>
                @if($consultaSeleccionada->tratamientos->count() > 0)
                    <table class="table table-sm table-striped mb-4">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Medicamento</th>
                                <th>Dosis</th>
                                <th>Frecuencia</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultaSeleccionada->tratamientos as $tratamiento)
                            <tr>
                                <td>{{ $tratamiento->nombre }}</td>
                                <td>{{ $tratamiento->medicamento }}</td>
                                <td>{{ $tratamiento->dosis }}</td>
                                <td>{{ $tratamiento->frecuencia }}</td>
                                <td>
                                    <span class="badge bg-{{ $tratamiento->estado == 'activo' ? 'success' : ($tratamiento->estado == 'completado' ? 'info' : 'warning') }}">
                                        {{ ucfirst($tratamiento->estado) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">No hay tratamientos registrados.</p>
                @endif

                <hr>

                <h6>Agregar Nuevo Tratamiento</h6>
                @if(count($tratamientos) > 0)
                    @foreach($tratamientos as $index => $tratamiento)
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <input type="text" class="form-control" placeholder="Nombre *" wire:model="tratamientos.{{ $index }}.nombre">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <input type="text" class="form-control" placeholder="Medicamento" wire:model="tratamientos.{{ $index }}.medicamento">
                                </div>
                                <div class="col-md-2 mb-2">
                                    <input type="text" class="form-control" placeholder="Dosis" wire:model="tratamientos.{{ $index }}.dosis">
                                </div>
                                <div class="col-md-2 mb-2">
                                    <input type="text" class="form-control" placeholder="Frecuencia" wire:model="tratamientos.{{ $index }}.frecuencia">
                                </div>
                                <div class="col-md-2 mb-2 d-flex align-items-center">
                                    <button class="btn btn-sm btn-danger" wire:click="quitarCampoTratamiento({{ $index }})">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
                
                <button class="btn btn-sm btn-success" wire:click="agregarCampoTratamiento">
                    <i class="bi bi-plus"></i> Agregar Tratamiento
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="cerrarModalTratamiento">Cerrar</button>
                @if(count($tratamientos) > 0)
                    <button type="button" class="btn btn-primary" wire:click="agregarTratamiento">Guardar Tratamientos</button>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif
@endsection
