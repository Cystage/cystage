<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postulation extends Model
{
    protected $fillable = ['offre_id','etu_id','state','motiv','path'];
}