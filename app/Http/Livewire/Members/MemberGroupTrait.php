<?php

namespace App\Http\Livewire\Members;

use App\Models\MemberGroup;

trait MemberGroupTrait
{
    public MemberGroup $memberGroup;
    public string $previousUrl;

    public ?string $parent = null;

    protected array $rules = [
        'memberGroup.title' => ['required', 'string', 'max:255'],
        'memberGroup.description' => ['nullable', 'string'],
        'parent' => ['nullable', 'int', 'exists:member_groups,id'],
    ];

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

        session()->put('message', $message);
        return redirect($this->previousUrl);
    }
}
