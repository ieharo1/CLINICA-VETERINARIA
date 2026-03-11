<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mascota extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'raza_id',
        'nombre',
        'especie',
        'genero',
        'fecha_nacimiento',
        'color',
        'peso',
        'foto',
        'notas',
        'esterilizado',
        'fecha_esterilizacion',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'esterilizado' => 'boolean',
        'fecha_esterilizacion' => 'date',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function raza(): BelongsTo
    {
        return $this->belongsTo(Raza::class);
    }

    public function consultas(): HasMany
    {
        return $this->hasMany(Consulta::class);
    }

    public function cirugias(): HasMany
    {
        return $this->hasMany(Cirugia::class);
    }

    public function vacunas(): BelongsToMany
    {
        return $this->belongsToMany(Vacuna::class, 'vacunas_mascotas')
            ->withPivot('fecha_aplicacion', 'proxima_fecha', 'lote', 'observaciones')
            ->withTimestamps();
    }

    public function getEdadAttribute(): int
    {
        return $this->fecha_nacimiento->age;
    }
}
