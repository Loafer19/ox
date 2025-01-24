<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'external_id', 'synced_at'];

    protected function casts(): array
    {
        return [
            'synced_at' => 'datetime',
        ];
    }
}
