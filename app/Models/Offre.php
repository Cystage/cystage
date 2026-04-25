<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    protected $fillable = ['nom','ent_id','nb_week','week_hour','paye_hour','teletrav','poste_desc','profil_desc'];
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'ent_id');
    }
}