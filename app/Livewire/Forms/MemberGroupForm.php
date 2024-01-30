<?php

namespace App\Livewire\Forms;

use App\Models\Member;
use App\Models\MemberGroup;
use Illuminate\Support\Arr;
use Livewire\Form;

class MemberGroupForm extends Form
{
    public ?MemberGroup $memberGroup = null;

    public string $title;

    public ?string $description;

    public ?string $parent = null;

    public array $memberSelection = [];

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'parent' => ['nullable', 'int', 'exists:member_groups,id'],
            'memberSelection' => ['array', 'nullable',
                function (string $attribute, mixed $value, \Closure $fail) {
                    self::memberSelectionCheck($attribute, $value, $fail);
                }],
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

    public function setModel(MemberGroup $memberGroup): void
    {
        $this->memberGroup = $memberGroup;
        $this->title = $this->memberGroup->title;
        $this->description = $this->memberGroup->description;
        $this->parent = $this->memberGroup->parent()->first()?->id;
        $this->memberSelection = Arr::pluck($this->memberGroup->members()->getResults(), 'id');
    }

    public function store(): void
    {
        $this->validate();

        $this->memberGroup = MemberGroup::create([
            ...$this->except(['parent', 'memberSelection']),
            'parent_id' => $this->getParentId(),
        ]);
        $this->memberGroup->members()->sync(array_unique($this->memberSelection));
    }

    public function update(): void
    {
        $this->validate();

        $this->memberGroup->update([
            ...$this->except(['parent', 'memberSelection']),
            'parent_id' => $this->getParentId(),
        ]);
        $this->memberGroup->members()->sync(array_unique($this->memberSelection));
    }

    private function getParentId(): ?int
    {
        $parentId = intval($this->parent);
        if ($parentId > 0 && $parentId !== $this->memberGroup?->id) {
            return $parentId;
        }

        return null;
    }

    public function delete(): void
    {
        $this->memberGroup->delete();
    }
}
