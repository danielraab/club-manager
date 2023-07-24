<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\MemberGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    public static int $memberCnt = 0;

    const MEMBER_GROUP_CNT = 10;

    private Collection $memberGroupCollection;

    private User $memberEdit;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->addUsers();
        $this->addMemberGroups();
        $this->addMembers();
    }

    private function addUsers()
    {

        $memberShow = User::factory()->create([
            'name' => 'Member Show',
            'email' => 'memberShow@draab.at',
            'password' => Hash::make('memberShow'),
        ]);
        $memberShow->userPermissions()
            ->attach(Member::MEMBER_SHOW_PERMISSION);

        $this->memberEdit = User::factory()->create([
            'name' => 'Member Edit',
            'email' => 'memberEdit@draab.at',
            'password' => Hash::make('memberEdit'),
        ]);
        $this->memberEdit->userPermissions()
            ->attach(Member::MEMBER_SHOW_PERMISSION);
        $this->memberEdit->userPermissions()
            ->attach(Member::MEMBER_EDIT_PERMISSION);
    }

    private function addMemberGroups(): void
    {
        MemberGroup::factory(2)->create();
        $this->memberGroupCollection = MemberGroup::factory(self::MEMBER_GROUP_CNT)->create();

        $this->memberGroupCollection->each(function (MemberGroup $memberGroup) {
            $memberGroup->parent()->associate(fake()->numberBetween(1, 2))->save();
        });
    }

    private function addMembers(): void
    {
        $coll = Member::factory(25)->create([
            'leaving_date' => null,
            'creator_id' => $this->memberEdit->id,
            'last_updater_id' => $this->memberEdit->id,
        ]);
        self::$memberCnt += 25;

        $coll = Member::factory(5)->create([
            'leaving_date' => null,
            'paused' => true,
            'creator_id' => $this->memberEdit->id,
            'last_updater_id' => $this->memberEdit->id,
        ]);
        self::$memberCnt += 5;

        $coll->each(function (Member $member) {
            $member->memberGroups()->attach(
                fake()->numberBetween(3, self::MEMBER_GROUP_CNT + 2));
        });

        $coll = Member::factory(10)->create([
            'title_pre' => null,
            'title_post' => null,
            'birthday' => null,
            'phone' => null,
            'email' => null,
            'street' => null,
            'zip' => null,
            'city' => null,
            'leaving_date' => null,
            'creator_id' => $this->memberEdit->id,
            'last_updater_id' => $this->memberEdit->id,
        ]);
        self::$memberCnt += 10;

        $coll->each(function (Member $member) {
            $member->memberGroups()->attach(
                fake()->numberBetween(3, self::MEMBER_GROUP_CNT + 2));
        });

        $coll = Member::factory(10)->create([
            'creator_id' => $this->memberEdit->id,
            'last_updater_id' => $this->memberEdit->id,
        ]);
        self::$memberCnt += 10;

        $coll->each(function (Member $member) {
            $member->memberGroups()->attach(3);
            $member->memberGroups()->attach(
                fake()->numberBetween(4, self::MEMBER_GROUP_CNT + 2));
        });
    }
}
