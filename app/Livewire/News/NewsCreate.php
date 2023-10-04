<?php

namespace App\Livewire\News;

use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class NewsCreate extends Component
{
    use NewsTrait;

    public function mount()
    {
        $this->news = new News();
        $this->news->enabled = true;
        $this->news->logged_in_only = false;
        $this->display_until = now()->setMinute(0)->setSecond(0)->formatDatetimeLocalInput();
        $this->previousUrl = url()->previous();
    }

    /**
     * @throws ValidationException
     */
    public function saveNews()
    {
        $this->validate();
        $this->additionalContentValidation();
        $this->propToModel();

        $this->news->creator()->associate(Auth::user());
        $this->news->lastUpdater()->associate(Auth::user());

        $this->news->save();
        session()->push('message', __('News successfully added.'));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.news.news-create')->layout('layouts.backend');
    }
}
