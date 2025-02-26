<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id',
        'status_id',
        'comment',
        'date',
        'files',
        'external_id',
        'synced_at',
    ];

    /**
     * @return BelongsTo<Client, covariant Order>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return BelongsTo<Status, covariant Order>
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * @param Builder<Order> $query
     */
    public function scopeByStatus(Builder $query, ?int $id): void
    {
        if ($id !== null) {
            $query->where('status_id', $id);
        }
    }

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'files' => 'array',
            'synced_at' => 'datetime',
        ];
    }
}
