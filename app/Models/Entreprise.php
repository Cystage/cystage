<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $fillable = ['user_id','nom','siret','adresse','code_postal','ville','pays','num_tel'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
