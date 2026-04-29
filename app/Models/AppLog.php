<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'action', 'description', 'ip'];

    protected $casts = ['created_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function log(?int $userId, string $action, string $description): void
    {
        static::create([
            'user_id'     => $userId,
            'action'      => $action,
            'description' => $description,
            'ip'          => request()->ip(),
        ]);
    }
}
