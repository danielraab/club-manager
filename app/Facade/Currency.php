<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;


/**
 * @method static getCurrencySymbol
 * @method static formatPrice(float $price, int $comma = 2): string
 *
 * @see \App\Currency\Currency
 */
class Currency extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "currency";
    }
}
