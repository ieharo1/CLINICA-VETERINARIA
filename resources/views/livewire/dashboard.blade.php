@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Dashboard</h1>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Clientes</h6>
                        <h2 class="mb-0">{{ $totalClientes }}</h2>
                    </div>
                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Mascotas</h6>
                        <h2 class="mb-0">{{ $totalMascotas }}</h2>
                    </div>
                    <i class="bi bi-heart fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Consultas Hoy</h6>
                        <h2 class="mb-0">{{ $consultasHoy }}</h2>
                    </div>
                    <i class="bi bi-calendar-check fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Vacunas Pendientes</h6>
                        <h2 class="mb-0">{{ $vacunasPendientes }}</h2>
                    </div>
                    <i class="bi bi-shield-exclamation fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Mascotas por Especie</h5>
            </div>
            <div class="card-body">
                @if(count($mascotasPorEspecie) > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Especie</th>
                                <th class="text-end">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mascotasPorEspecie as $item)
                            <tr>
                                <td>{{ ucfirst($item['especie']) }}</td>
                                <td class="text-end">{{ $item['total'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">No hay mascotas registradas.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-bell"></i> Vacunas Próximas (30 días)</h5>
            </div>
            <div class="card-body">
                @if(count($vacunasProximas) > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Mascota</th>
                                <th>Vacuna</th>
                                <th>Próxima Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vacunasProximas as $item)
                            <tr>
                                <td>{{ $item->nombre_mascota }}</td>
                                <td>{{ $item->nombre_vacuna }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->proxima_fecha)->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">No hay vacunas próximas.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Consultas Recientes</h5>
            </div>
            <div class="card-body">
                @if(count($consultasRecientes) > 0)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Mascota</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultasRecientes as $consulta)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($consulta['fecha_consulta'])->format('d/m/Y H:i') }}</td>
                                <td>{{ $consulta['mascota']['nombre'] }}</td>
                                <td>{{ $consulta['motivo'] }}</td>
                                <td>
                                    <span class="badge bg-{{ $consulta['estado'] == 'completada' ? 'success' : ($consulta['estado'] == 'cancelada' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($consulta['estado']) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">No hay consultas recientes.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
