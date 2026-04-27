<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = ['nom','ent_id','etu_id','nb_week','week_hour','paye_hour','teletrav','poste_desc','profil_desc','domaines','competences','state'];
}