<?php

namespace App\Livewire;

use App\Models\Configuration;
use App\Models\ConfigurationKey;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Development extends Component
{

    public function download(string $path): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return response()->download($path);
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.development')->layout('layouts.backend');
    }
}
