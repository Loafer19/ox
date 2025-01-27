<?php

namespace App\Models;

use Database\Factories\StatusFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    /** @use HasFactory<StatusFactory> */
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * @return HasMany<Order, covariant Status>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
