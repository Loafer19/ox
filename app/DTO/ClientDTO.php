<?php

namespace App\DTO;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class ClientDTO implements Arrayable
{
    public int $external_id;

    public string $name;

    public string $synced_at;

    public function __construct(int $external_id, string $name, string $synced_at)
    {
        $this->external_id = $external_id;
        $this->name = $name;
        $this->synced_at = $synced_at;
    }

    /**
     * @return array{external_id: int, name: string, synced_at: string}
     */
    public function toArray(): array
    {
        return [
            'external_id' => $this->external_id,
            'name' => $this->name,
            'synced_at' => $this->synced_at,
        ];
    }
}
