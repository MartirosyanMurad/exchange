<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @package App\Repository
 */
interface RateRepositoryInterface
{
    /**
     * @return Collection
     */
    public function get(): Collection;

    /**
     * @param string $value
     *
     * @return Model|null
     */
    public function getOne(string $value): ?Model;
}
