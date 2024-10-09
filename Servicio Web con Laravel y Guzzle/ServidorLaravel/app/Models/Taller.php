<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Taller extends Model
{
    use HasFactory;

    protected $table = 'talleres';

    protected $fillable = ['nombre', 'descripcion', 'dia_semana', 'hora_inicio', 'hora_fin', 'cupo_maximo','ubicacion_id'] ;

    //Relación N-1. N talleres pueden estar en una ubicación.
    public function Ubicacion(): BelongsTo{
        return $this->belongsTo(Ubicacion::class);
    }

    
}
