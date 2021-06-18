<?php

declare(strict_types=1);

namespace App\Services;

use App\Repository\Contracts\RateRepositoryInterface;
use App\Services\Contracts\RateServiceInterface;
use function strtoupper;

/**
 * @package App\Services
 */
class BlockChainRateService implements RateServiceInterface
{
    private const BTC = 'BTC';

    /**
     * @var RateRepositoryInterface
     */
    private $rateRepository;

    public function __construct(RateRepositoryInterface $rateRepository)
    {
        $this->rateRepository = $rateRepository;
    }

    /**
     * @inheritdoc
     */
    public function getRates(): array
    {
        $result = [];
        $ratesToArray = $this->rateRepository->get()->toArray();

        foreach ($ratesToArray as $rate) {
            $result[$rate['currency']] = $this->getValueWithCommission($rate['value'], $rate['commission']);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function convert(array $data): array
    {
        $btcIsFrom = true;
        $upperCurrencyFrom = strtoupper($data['currency_from']);
        $upperCurrencyTo = strtoupper($data['currency_to']);

        if ($upperCurrencyFrom === self::BTC) {
            $currencyName = $upperCurrencyTo;
            $decimal = 2;
        } else {
            $btcIsFrom = false;
            $currencyName = $upperCurrencyFrom;
            $decimal = 10;
        }

        $currency = $this->rateRepository->getOne($currencyName);

        if (is_null($currency)) {
            return [];
        }

        $currency = $currency->toArray();

        $convertedValue = $btcIsFrom ?
             $this->getValueWithCommission($data['value'] * $currency['value'], $currency['commission'])
            : $this->getValueWithCommission($data['value'] / $currency['value'], $currency['commission']);

        $rate = $btcIsFrom ?
            $this->getValueWithCommission($currency['value'], $currency['commission'])
            : (float)number_format($this->getValueWithCommission(1/$currency['value'], $currency['commission']), 10, '.', '');

        return [
            'currency_from' => $upperCurrencyFrom,
            'currency_to' => $upperCurrencyTo,
            'value' => $data['value'],
            'converted_value' => (float)number_format($convertedValue, $decimal, '.', ''),
            'rate' => $rate,
            'created_at' => time()
        ];
    }

    /**
     * @param float $value
     * @param float $commission
     *
     * @return float
     */
    private function getValueWithCommission(float $value, float $commission): float
    {
        return $value * ((100 - $commission) / 100);
    }
}
