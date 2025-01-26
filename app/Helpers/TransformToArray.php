<?php

namespace App\Helpers;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @template TKey of array-key
 * @template TValue
 */
class TransformToArray
{
    /**
     * @param Arrayable<TKey, TValue> $object
     * @return array<TKey, TValue>
     */
    public function __invoke(Arrayable $object): array
    {
        return $object->toArray();
    }
}
