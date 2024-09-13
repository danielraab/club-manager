<?php

namespace Tests\Feature\PagePermission;

use App\Models\Import\ImportedMember;
use App\Models\Member;
use App\Models\MemberGroup;
use App\Models\UserPermission;

class MemberTest extends TestPagePermission
{
    protected function doAdditionalSeeds(): void
    {
        Member::factory()->create();
        MemberGroup::factory()->create();
    }

    protected function getPermissionsToTest(): array
    {
        return [
            UserPermission::ADMIN_USER_PERMISSION,
            Member::MEMBER_SHOW_PERMISSION,
            Member::MEMBER_EDIT_PERMISSION,
            ImportedMember::MEMBER_IMPORT_PERMISSION,
        ];
    }

    public function getRoutesWithPermissions(): array
    {
        return [
            '/members' => [Member::MEMBER_SHOW_PERMISSION, Member::MEMBER_EDIT_PERMISSION],
            '/members/list/csv' => [Member::MEMBER_SHOW_PERMISSION, Member::MEMBER_EDIT_PERMISSION],
            '/members/list/excel' => [Member::MEMBER_SHOW_PERMISSION, Member::MEMBER_EDIT_PERMISSION],
            '/members/birthdayList/print' => [Member::MEMBER_SHOW_PERMISSION, Member::MEMBER_EDIT_PERMISSION],
            '/members/birthdayList' => [Member::MEMBER_SHOW_PERMISSION, Member::MEMBER_EDIT_PERMISSION],
            '/members/import' => [ImportedMember::MEMBER_IMPORT_PERMISSION],
            '/members/groups' => [Member::MEMBER_EDIT_PERMISSION],
            '/members/groups/create' => [Member::MEMBER_EDIT_PERMISSION],
            '/members/groups/1' => [Member::MEMBER_EDIT_PERMISSION],
            '/members/member/create' => [Member::MEMBER_EDIT_PERMISSION],
            '/members/member/1' => [Member::MEMBER_EDIT_PERMISSION],
        ];
    }
}
