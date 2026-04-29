<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostulationCommentaire extends Model
{
    protected $fillable = ['postulation_id', 'user_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postulation()
    {
        return $this->belongsTo(Postulation::class);
    }
}
