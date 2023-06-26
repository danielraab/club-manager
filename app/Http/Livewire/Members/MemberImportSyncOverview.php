<?php

namespace App\Http\Livewire\Members;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class MemberImportSyncOverview extends Component
{
    public array $keyedData = [];

    public function syncMembers() {
    }

    public function render()
    {
        return view('livewire.members.member-import-sync-overview');
    }
}
