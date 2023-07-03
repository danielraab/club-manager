<?php

namespace App\Http\Livewire\Members;

use App\Models\Member;
use App\Models\MemberGroup;
use Carbon\Carbon;

trait MemberTrait
{
    public Member $member;
    public array $memberGroupList;
    public ?string $birthday = null;
    public string $entrance_date;
    public ?string $leaving_date = null;
    public string $previousUrl;

    protected function rules()
    {
        return [
            'member.firstname' => ['required', 'string', 'max:255'],
            'member.lastname' => ['required', 'string', 'max:255'],
            'member.title_pre' => ['nullable', 'string', 'max:255'],
            'member.title_post' => ['nullable', 'string', 'max:255'],
            'member.special' => ['nullable', 'boolean'],
            'member.phone' => ['nullable', 'string', 'max:255'],
            'member.email' => ['nullable', 'email', 'max:255'],
            'member.street' => ['nullable', 'string', 'max:255'],
            'member.zip' => ['nullable', 'integer'],
            'member.city' => ['nullable', 'string', 'max:255'],

            'entrance_date' => ['required', 'date'],
            'leaving_date' => ['nullable', 'date', 'after_or_equal:entrance_date'],
            'birthday' => ['nullable', 'date'],

            'memberGroupList' => ['nullable', 'array',
                function (string $attribute, mixed $value, \Closure $fail) {
                    self::memberGroupSelectionCheck($attribute, $value, $fail);
                }]
        ];
    }

    private static function memberGroupSelectionCheck(string $attribute, mixed $value, \Closure $fail): void
    {
        if (is_array($value)) {
            $possibleMemberGroups = MemberGroup::getLeafQuery()->pluck('id')->toArray();
            if (count(array_diff($value, $possibleMemberGroups)) > 0) {
                $fail('Some selected member groups are not valid. Please refresh the page and try again.');
            }
        }
    }

    protected function propsToModel() {
        if($this->birthday) $this->member->birthday = new Carbon($this->birthday);
        else $this->member->birthday = null;
        if($this->entrance_date) $this->member->entrance_date = new Carbon($this->entrance_date);
        if($this->leaving_date) $this->member->leaving_date = new Carbon($this->leaving_date);
        else $this->member->leaving_date = null;
    }
}
