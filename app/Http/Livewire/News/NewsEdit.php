<?php

namespace App\Http\Livewire\News;

use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NewsEdit extends Component
{
    use NewsTrait;

    public function mount(News $news)
    {
        $this->news = $news;
        $this->display_until = $news->display_until;
    }

    public function deleteNews()
    {
        $this->news->delete();
        session()->put("message", __("The news has been successfully deleted."));
        $this->redirect(route("news.index"));
    }

    public function saveNews() {
        $this->validate();
        $this->additionalContentValidation();
        $this->news->display_until = $this->display_until;

        $this->news->lastUpdater()->associate(Auth::user());

        $this->news->save();
        session()->put("message", __("News successfully updated."));

        $this->redirect(route("news.index"));
    }

    public function render()
    {
        return view('livewire.news.news-edit')->layout('layouts.backend');
    }
}
