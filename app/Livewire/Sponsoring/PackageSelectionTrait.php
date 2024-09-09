<?php

namespace App\Livewire\Sponsoring;

use App\Models\Sponsoring\Package;
use App\Models\Sponsoring\Period;
use Illuminate\Support\Arr;

trait PackageSelectionTrait
{
    private static ?array $packages = null;

    public array $availablePackageArr = [];

    public array $selectedPackageArr = [];

    private function loadAvailablePackages(): void
    {
        $packagesArr = Package::allActive(false)->get(['id', 'title'])->toArray();
        $this->availablePackageArr = Arr::mapWithKeys($packagesArr, function (array $package) {
            return [$package['id'] => $package['title']];
        });
    }

    private function loadSelectedPackages(Period $period): void
    {
        $this->selectedPackageArr = $period->packages()->get(['id'])->pluck('id')->toArray();
    }
}
