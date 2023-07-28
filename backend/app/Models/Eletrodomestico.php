<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eletrodomestico extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'descricao',
        'tensao',
        'id_marca'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id_marca'
    ];

    /**
     * Get the Marca that wrote the Marca.
     */
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca', 'id');
    }
}
