<?php

namespace App\Http\Livewire\Members;

use App\Models\Member;
use App\Models\MemberGroup;

trait MemberGroupTrait
{
    public MemberGroup $memberGroup;
    public string $previousUrl;

    public ?string $parent = null;
    public array $memberSelection = [];

    protected function rules()
    {
        return[
            'memberGroup.title' => ['required', 'string', 'max:255'],
            'memberGroup.description' => ['nullable', 'string'],
            'parent' => ['nullable', 'int', 'exists:member_groups,id'],
            'memberSelection' => ['array', 'nullable',
                function (string $attribute, mixed $value, \Closure $fail) {
                    self::memberSelectionCheck($attribute, $value, $fail);
                }]
        ];
    }

    private static function memberSelectionCheck(string $attribute, mixed $value, \Closure $fail): void
    {
        if (is_array($value)) {
            $possibleMembers = Member::all('id')->pluck('id')->toArray();
            if (count(array_diff($value, $possibleMembers)) > 0) {
                $fail('Some selected members are not valid. Please refresh the page and try again.');
            }
        }
    }

    public function propToModel()
    {
        $parentId = intval($this->parent);
        if ($parentId > 0 && $parentId !== $this->memberGroup->id) {
            $this->memberGroup->parent_id = $parentId;
        } else {
            $this->memberGroup->parent_id = null;
        }
    }

    protected function saveMemberGroupWithMessage(string $message): \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Foundation\Application
    {
        $this->validate();
        $this->propToModel();
        $this->memberGroup->save();

        $this->memberGroup->members()->sync(array_unique($this->memberSelection));

        session()->put('message', $message);
        return redirect($this->previousUrl);
    }
}
