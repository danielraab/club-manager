<?php

namespace App\Livewire\Sponsoring;

use App\Models\Sponsoring\Package;
use Illuminate\Support\Arr;

trait PackageSelectionTrait
{
    private static ?array $packages = null;

    public array $availablePackageArr = [];

    public array $selectedPackageArr = [];

    private function getPackageArr(): array
    {
        if (self::$packages === null) {
            $packagesArr = Package::allActive()->get(['id', 'title'])->toArray();
            self::$packages = Arr::mapWithKeys($packagesArr, function (array $package) {
                return [$package['id'] => $package['title']];
            });
        }

        return self::$packages;
    }
}
