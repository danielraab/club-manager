<?php

namespace App\Livewire\Sponsoring;

use App\Models\Sponsoring\AdOption;
use Illuminate\Support\Arr;

trait AdOptionSelectionTrait
{
    private static ?array $adOptions = null;
    public array $availableAdOptionArr = [];
    public array $selectedAdOptionArr = [];

    private function getAdOptionArr(): array {
        if(self::$adOptions === null) {
            $adOptionsArr = AdOption::allActive()->get(["id", "title"])->toArray();
            self::$adOptions = Arr::mapWithKeys($adOptionsArr, function (array $adOption) {
                return [$adOption['id'] => $adOption['title']];
            });
        }
        return self::$adOptions;
    }
}
