<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Raza extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'especie',
        'descripcion',
    ];

    public function mascotas(): HasMany
    {
        return $this->hasMany(Mascota::class);
    }
}
