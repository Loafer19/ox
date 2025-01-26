<?php

namespace App\DTO;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class OrderDTO implements Arrayable
{
    public int $external_id;

    public ClientDTO $clientDTO;

    public string $comment;

    public string $synced_at;

    public function __construct(int $external_id, ClientDTO $clientDTO, string $comment, string $synced_at)
    {
        $this->external_id = $external_id;
        $this->clientDTO = $clientDTO;
        $this->comment = $comment;
        $this->synced_at = $synced_at;
    }

    /**
     * @return array{external_id: int, clientDTO: ClientDTO, comment: string, synced_at: string}
     */
    public function toArray(): array
    {
        return [
            'external_id' => $this->external_id,
            'clientDTO' => $this->clientDTO,
            'comment' => $this->comment,
            'synced_at' => $this->synced_at,
        ];
    }
}
