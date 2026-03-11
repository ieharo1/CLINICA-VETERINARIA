<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cirugia extends Model
{
    use HasFactory;

    protected $fillable = [
        'mascota_id',
        'user_id',
        'nombre',
        'fecha_cirugia',
        'descripcion',
        'preoperatorio',
        'postoperatorio',
        'observaciones',
        'estado',
        'costo',
    ];

    protected $casts = [
        'fecha_cirugia' => 'datetime',
        'costo' => 'decimal:2',
    ];

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
