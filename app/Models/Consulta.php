<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'mascota_id',
        'user_id',
        'fecha_consulta',
        'motivo',
        'sintomas',
        'diagnostico',
        'tratamiento',
        'peso_actual',
        'temperatura',
        'frecuencia_cardiaca',
        'frecuencia_respiratoria',
        'observaciones',
        'estado',
    ];

    protected $casts = [
        'fecha_consulta' => 'datetime',
    ];

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tratamientos(): HasMany
    {
        return $this->hasMany(Tratamiento::class);
    }
}
