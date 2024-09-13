<?php

namespace Tests\Feature\PagePermission;

use App\Models\Sponsoring\AdOption;
use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Package;
use App\Models\Sponsoring\Period;
use App\Models\UserPermission;

class SponsoringTest extends TestPagePermission
{
    protected function doAdditionalSeeds(): void
    {
        $backer = Backer::factory()->create();
        $adOption = AdOption::factory()->create();
        $package = Package::factory()->create();
        $period = Period::factory()->create();
        $contract = Contract::factory()->create([
            'backer_id' => $backer->id,
            'period_id' => $period->id,
        ]);
    }

    protected function getPermissionsToTest(): array
    {
        return [
            UserPermission::ADMIN_USER_PERMISSION,
            Contract::SPONSORING_SHOW_PERMISSION,
            Contract::SPONSORING_EDIT_PERMISSION,
        ];
    }

    public function getRoutesWithPermissions(): array
    {
        return [
            '/sponsoring' => [Contract::SPONSORING_SHOW_PERMISSION, Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/backer' => [Contract::SPONSORING_SHOW_PERMISSION, Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/adOption' => [Contract::SPONSORING_SHOW_PERMISSION, Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/package' => [Contract::SPONSORING_SHOW_PERMISSION, Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/period/backer/1' => [Contract::SPONSORING_SHOW_PERMISSION, Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/period/adOption/1' => [Contract::SPONSORING_SHOW_PERMISSION, Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/contract/1' => [Contract::SPONSORING_SHOW_PERMISSION, Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/period/1/export/csv' => [Contract::SPONSORING_SHOW_PERMISSION, Contract::SPONSORING_EDIT_PERMISSION],

            '/sponsoring/backer/create' => [Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/backer/1' => [Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/adOption/create' => [Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/adOption/1' => [Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/package/create' => [Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/package/1' => [Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/period/create' => [Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/period/1' => [Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/period/1/memberAssignment' => [Contract::SPONSORING_EDIT_PERMISSION],
            '/sponsoring/contract/1/edit' => [Contract::SPONSORING_EDIT_PERMISSION],
        ];
    }
}
