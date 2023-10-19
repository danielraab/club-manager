<?php

namespace App\Livewire\Forms;

use App\Models\Member;
use App\Models\MemberGroup;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class MemberForm extends Form
{
    public ?Member $member = null;

    public string $firstname;
    public string $lastname;
    public ?string $title_pre;
    public ?string $title_post;
    public ?bool $paused;
    public ?string $phone;
    public ?string $email;
    public ?string $street;
    public ?int $zip;
    public ?string $city;


    public ?string $birthday = null;
    public string $entrance_date;
    public ?string $leaving_date = null;

    public array $memberGroupList;


    protected function rules(): array
    {
        return [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'title_pre' => ['nullable', 'string', 'max:255'],
            'title_post' => ['nullable', 'string', 'max:255'],
            'paused' => ['nullable', 'boolean'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'street' => ['nullable', 'string', 'max:255'],
            'zip' => ['nullable', 'integer'],
            'city' => ['nullable', 'string', 'max:255'],

            'entrance_date' => ['required', 'date'],
            'leaving_date' => ['nullable', 'date', 'after_or_equal:memberForm.entrance_date'],
            'birthday' => ['nullable', 'date'],

            'memberGroupList' => ['nullable', 'array',
                function (string $attribute, mixed $value, \Closure $fail) {
                    self::memberGroupSelectionCheck($attribute, $value, $fail);
                }],
        ];
    }
    public function setMemberModal(Member $member): void
    {
        $this->member = $member;

        $this->firstname = $member->firstname;
        $this->lastname = $member->lastname;
        $this->title_pre = $member->title_pre;
        $this->title_post = $member->title_post;
        $this->paused = $member->paused;
        $this->phone = $member->phone;
        $this->email = $member->email;
        $this->street = $member->street;
        $this->zip = $member->zip;
        $this->city = $member->city;

        $this->birthday = $member->birthday?->format('Y-m-d');
        $this->entrance_date = $member->entrance_date->format('Y-m-d');
        $this->leaving_date = $member->leaving_date?->format('Y-m-d');
        $this->memberGroupList = Arr::pluck($member->memberGroups()->getResults(), 'id');
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

    public function store(): void
    {
        $this->validate();

        $this->member = Member::create([
            ...$this->except(["member", "birthday", "entrance_date", "leaving_date", "memberGroupList"]),
            "birthday" => $this->birthday ? new Carbon($this->birthday) : null,
            "entrance_date" => $this->entrance_date ? new Carbon($this->entrance_date) : null,
            "leaving_date" => $this->leaving_date ? new Carbon($this->leaving_date) : null
        ]);

        $this->member->creator()->associate(Auth::user());
        $this->member->lastUpdater()->associate(Auth::user());
        $this->member->save();

        $this->member->memberGroups()->sync(array_unique($this->memberGroupList));
    }

    public function update():void
    {
        $this->validate();

        $this->member->update([
            ...$this->except(["member", "birthday", "entrance_date", "leaving_date", "memberGroupList"]),
            "birthday" => $this->birthday ? new Carbon($this->birthday) : null,
            "entrance_date" => $this->entrance_date ? new Carbon($this->entrance_date) : null,
            "leaving_date" => $this->leaving_date ? new Carbon($this->leaving_date) : null
        ]);

        $this->member->lastUpdater()->associate(Auth::user());
        $this->member->memberGroups()->sync(array_unique($this->memberGroupList));
        $this->member->save();
    }

    public function delete(): void
    {
        $this->member?->delete();
    }
}
