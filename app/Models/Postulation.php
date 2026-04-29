<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postulation extends Model
{
    protected $fillable = ['offre_id','etu_id','state','motiv','path','archived'];

    public function etudiant() {
        return $this->belongsTo(Etudiant::class, 'etu_id');
    }

    public function offre() {
        return $this->belongsTo(Offre::class, 'offre_id');
    }

    public function commentaires() {
        return $this->hasMany(PostulationCommentaire::class);
    }
}