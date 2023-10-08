<?php

namespace App\Livewire\News;

use App\Livewire\Forms\NewsForm;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class NewsCreate extends Component
{
    public NewsForm $newsForm;
    public string $previousUrl;

    public function mount(): void
    {
        $this->newsForm->display_until = now()->addWeek()->setMinute(0)->setSecond(0)->formatDatetimeLocalInput();
        $this->previousUrl = url()->previous();
    }

    /**
     * @throws ValidationException
     */
    public function saveNews()
    {
        $this->newsForm->store();
        session()->push('message', __('News successfully added.'));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.news.news-create')->layout('layouts.backend');
    }
}
