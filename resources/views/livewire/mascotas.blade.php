@extends('layouts.app')

@section('title', 'Mascotas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="bi bi-heart"></i> Mascotas</h1>
            <button class="btn btn-primary" wire:click="crearMascota">
                <i class="bi bi-plus-circle"></i> Nueva Mascota
            </button>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" class="form-control" placeholder="Buscar mascotas..." wire:model="search">
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Dueño</th>
                        <th>Especie</th>
                        <th>Raza</th>
                        <th>Edad</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mascotas as $mascota)
                    <tr>
                        <td>
                            @if($mascota->foto)
                                <img src="{{ asset('storage/' . $mascota->foto) }}" alt="{{ $mascota->nombre }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-heart text-white"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $mascota->nombre }}</td>
                        <td>{{ $mascota->cliente->nombre }} {{ $mascota->cliente->apellido }}</td>
                        <td>{{ ucfirst($mascota->especie) }}</td>
                        <td>{{ $mascota->raza?->nombre ?? 'N/A' }}</td>
                        <td>{{ $mascota->edad }} años</td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-info" wire:click="verHistorial({{ $mascota->id }})" title="Ver Historial">
                                <i class="bi bi-journal-medical"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" wire:click="editarMascota({{ $mascota->id }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" wire:click="eliminarMascota({{ $mascota->id }})" onclick="return confirm('¿Está seguro de eliminar esta mascota?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $mascotas->links() }}
    </div>
</div>

@if($mostrarModal)
<div class="modal fade show" style="display: block;" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $mascotaId ? 'Editar' : 'Nueva' }} Mascota</h5>
                <button type="button" class="btn-close" wire:click="cerrarModal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cliente *</label>
                        <select class="form-select" wire:model="cliente_id">
                            <option value="">Seleccionar cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->apellido }} {{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                        @error('cliente_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" class="form-control" wire:model="nombre">
                        @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Especie *</label>
                        <select class="form-select" wire:model="especie">
                            <option value="">Seleccionar</option>
                            <option value="perro">Perro</option>
                            <option value="gato">Gato</option>
                            <option value="ave">Ave</option>
                            <option value="otro">Otro</option>
                        </select>
                        @error('especie') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Raza</label>
                        <select class="form-select" wire:model="raza_id">
                            <option value="">Seleccionar raza</option>
                            @foreach($razas as $raza)
                                <option value="{{ $raza->id }}">{{ $raza->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Género *</label>
                        <select class="form-select" wire:model="genero">
                            <option value="">Seleccionar</option>
                            <option value="macho">Macho</option>
                            <option value="hembra">Hembra</option>
                        </select>
                        @error('genero') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fecha de Nacimiento *</label>
                        <input type="date" class="form-control" wire:model="fecha_nacimiento">
                        @error('fecha_nacimiento') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Color</label>
                        <input type="text" class="form-control" wire:model="color">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Peso (kg)</label>
                        <input type="text" class="form-control" wire:model="peso">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Foto</label>
                        <input type="file" class="form-control" wire:model="foto" accept="image/*">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Esterilizado</label>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" wire:model="esterilizado" id="esterilizado">
                            <label class="form-check-label" for="esterilizado">Sí</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notas</label>
                    <textarea class="form-control" wire:model="notas" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="cerrarModal">Cancelar</button>
                <button type="button" class="btn btn-primary" wire:click="guardarMascota">Guardar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif

@if($mostrarModalHistorial && $mascotaSeleccionada)
<div class="modal fade show" style="display: block;" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Historial Médico - {{ $mascotaSeleccionada->nombre }}</h5>
                <button type="button" class="btn-close" wire:click="cerrarModalHistorial"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="historialTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="consultas-tab" data-bs-toggle="tab" data-bs-target="#consultas" type="button">Consultas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="cirugias-tab" data-bs-toggle="tab" data-bs-target="#cirugias" type="button">Cirugías</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="vacunas-tab" data-bs-toggle="tab" data-bs-target="#vacunas" type="button">Vacunas</button>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="historialTabContent">
                    <div class="tab-pane fade show active" id="consultas" role="tabpanel">
                        @if(count($historialMedico['consultas']) > 0)
                            @foreach($historialMedico['consultas'] as $consulta)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h6>{{ $consulta->fecha_consulta->format('d/m/Y') }} - {{ $consulta->motivo }}</h6>
                                    <p><strong>Diagnóstico:</strong> {{ $consulta->diagnostico }}</p>
                                    <p><strong>Tratamiento:</strong> {{ $consulta->tratamiento }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted">No hay consultas registradas.</p>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="cirugias" role="tabpanel">
                        @if(count($historialMedico['cirugias']) > 0)
                            @foreach($historialMedico['cirugias'] as $cirugia)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h6>{{ $cirugia->fecha_cirugia->format('d/m/Y') }} - {{ $cirugia->nombre }}</h6>
                                    <p><strong>Estado:</strong> {{ ucfirst($cirugia->estado) }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted">No hay cirugías registradas.</p>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="vacunas" role="tabpanel">
                        @if(count($historialMedico['vacunas']) > 0)
                            @foreach($historialMedico['vacunas'] as $vacuna)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h6>{{ $vacuna->nombre }}</h6>
                                    <p><strong>Aplicación:</strong> {{ $vacuna->pivot->fecha_aplicacion }}</p>
                                    <p><strong>Próxima:</strong> {{ $vacuna->pivot->proxima_fecha ?? 'N/A' }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted">No hay vacunas registradas.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="cerrarModalHistorial">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif
@endsection
