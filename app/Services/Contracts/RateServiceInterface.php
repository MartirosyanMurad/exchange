<?php

declare(strict_types=1);

namespace App\Services\Contracts;

/**
 * @package App\Services\Contracts
 */
interface RateServiceInterface
{
    /**
     * @return array
     */
    public function getRates(): array;

    /**
     * @param array $data
     *
     * @return array
     */
    public function convert(array $data): array;
}
