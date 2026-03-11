<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tratamiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'consulta_id',
        'nombre',
        'medicamento',
        'dosis',
        'frecuencia',
        'duracion_dias',
        'fecha_inicio',
        'fecha_fin',
        'observaciones',
        'estado',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function consulta(): BelongsTo
    {
        return $this->belongsTo(Consulta::class);
    }
}
