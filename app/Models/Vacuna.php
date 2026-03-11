<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vacuna extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'dias_referencia',
        'es_obligatoria',
    ];

    protected $casts = [
        'es_obligatoria' => 'boolean',
    ];

    public function mascotas(): BelongsToMany
    {
        return $this->belongsToMany(Mascota::class, 'vacunas_mascotas')
            ->withPivot('fecha_aplicacion', 'proxima_fecha', 'lote', 'observaciones')
            ->withTimestamps();
    }
}
