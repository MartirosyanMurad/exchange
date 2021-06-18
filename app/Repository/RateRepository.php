<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Rate;
use App\Repository\Contracts\RateRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @package App\Repository
 */
class RateRepository implements RateRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function get(): Collection
    {
        return QueryBuilder::for(Rate::class)
            ->allowedFilters('currency')
            ->get();
    }

    /**
     * @inheritdoc
     */
    public function getOne(string $value): ?Model
    {
        return QueryBuilder::for(Rate::class)
            ->where('currency', '=', $value)
            ->first();
    }
}
