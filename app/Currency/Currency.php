<?php

namespace App\Currency;

class Currency
{
    public const CONFIG_EURO = 'eur';

    private string $currencyConfig;

    public function __construct()
    {
        $this->currencyConfig = config('app.currency');
    }

    public function getCurrencySymbol(): string
    {
        return match ($this->currencyConfig) {
            self::CONFIG_EURO => '€'
        };
    }

    public function formatPrice(float $price, int $comma = 2): string
    {
        return match ($this->currencyConfig) {
            self::CONFIG_EURO => sprintf("%.${comma}f €", $price)
        };
    }
}
