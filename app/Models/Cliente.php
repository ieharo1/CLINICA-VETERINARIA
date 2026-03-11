<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'email',
        'direccion',
        'ciudad',
        'notas',
    ];

    public function mascotas(): HasMany
    {
        return $this->hasMany(Mascota::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->nombre . ' ' . $this->apellido;
    }
}
