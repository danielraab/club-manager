<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Member;
use App\Models\MemberGroup;
use App\Models\User;
use Database\Factories\MemberGroupFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{

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
        $this->memberGroupCollection = MemberGroup::factory(self::MEMBER_GROUP_CNT)->create();
    }

    private function addMembers(): void
    {
        $coll = Member::factory(40)->create([
            "creator_id" => $this->memberEdit->id,
            "last_updater_id" => $this->memberEdit->id
        ]);
        $coll->each(function(Member $member) {
            $member->memberGroups()->attach(
                fake()->numberBetween(2, self::MEMBER_GROUP_CNT));
        });

        $coll = Member::factory(10)->create([
            "creator_id" => $this->memberEdit->id,
            "last_updater_id" => $this->memberEdit->id
        ]);
        $coll->each(function(Member $member) {
            $member->memberGroups()->attach(1);
            $member->memberGroups()->attach(
                fake()->numberBetween(2, self::MEMBER_GROUP_CNT));
        });
    }
}
