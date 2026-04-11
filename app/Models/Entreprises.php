<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprises extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'siret',
        'adresse',
        'code_postal',
        'ville',
        'pays',
    ];
}
