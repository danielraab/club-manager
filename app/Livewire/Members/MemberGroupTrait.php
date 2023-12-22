<?php

namespace App\Livewire\Members;

trait MemberGroupTrait
{
    public string $previousUrl;

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
