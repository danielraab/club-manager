<?php

namespace App\Models;

use Illuminate\Support\Facades\File;

class Country
{
    /**
     * from https://gist.githubusercontent.com/ssskip/5a94bfcd2835bf1dea52/raw/3b2e5355eb49336f0c6bc0060c05d927c2d1e004/ISO3166-1.alpha2.json
     */
    private const COUNTRY_DATA_PATH = 'data/ISO3166-1.alpha2.json';

    private static ?array $countryArr = null;

    public static function array(): array
    {
        if (self::$countryArr === null) {
            self::$countryArr = json_decode(File::get(resource_path(self::COUNTRY_DATA_PATH)), true);
        }

        return self::$countryArr;
    }

    public static function getName(string $code): string
    {
        return self::array()[mb_strtoupper($code)] ?? '';
    }

    public static function codes(): array
    {
        return array_keys(self::array());
    }
}
