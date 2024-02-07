<?php

namespace Database\Seeders;

use App\Models\Sponsoring\AdOption;
use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Package;
use App\Models\Sponsoring\Period;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SponsoringSeeder extends Seeder
{

    private Collection $memberGroupCollection;

    private User $sponsoringEdit;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->addUsers();
        $this->addBackers();
        $this->addAdOptions();
        $this->addPackages();
        $this->addPeriods();
        $this->addContracts();
    }

    private function addUsers(): void
    {
        $this->sponsoringEdit = User::factory()->create([
            'name' => 'Sponsoring Edit',
            'email' => 'sponsoringEdit@draab.at',
            'password' => Hash::make('sponsoringEdit'),
        ]);
        $this->sponsoringEdit->userPermissions()
            ->attach(Backer::SPONSORING_EDIT_PERMISSION);
    }

    private function addBackers(): void
    {
        Backer::factory(100)->create();
    }

    private function addAdOptions(): void
    {
        AdOption::factory(10)->create();
    }

    private function addPackages(): void
    {
        Package::factory(10)->create();
        //TODO add links to AdOptions
    }

    private function addPeriods(): void
    {
        Period::factory(5)->create();
        //TODO add links to Packages
    }

    private function addContracts(): void
    {
        Contract::factory(500)->create();
        //TODO add links to periods and packages
    }
}
