<?php

namespace App\Livewire\News;

use App\Models\News;
use App\Notifications\UpcomingEvent;
use App\Notifications\UpcomingNews;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use NotificationChannels\WebPush\PushSubscription;

class NewsEdit extends Component
{
    use NewsTrait;

    public function mount(News $news): void
    {
        $this->news = $news;
        $this->display_until = $news->display_until->formatDatetimeLocalInput();
        $this->previousUrl = url()->previous();
    }

    public function deleteNews()
    {
        $this->news->delete();
        session()->put('message', __('The news has been successfully deleted.'));

        return redirect($this->previousUrl);
    }

    public function saveNewsCopy()
    {

        $this->validate();
        $this->additionalContentValidation();
        $this->propToModel();

        $this->news->creator()->associate(Auth::user());
        $this->news->lastUpdater()->associate(Auth::user());

        $this->news = $this->news->replicate();
        $this->news->save();

        session()->put('message', __('News successfully created.'));
        return redirect(route('news.edit', ['news' => $this->news->id]));
    }

    public function saveNews()
    {
        $this->validate();
        $this->additionalContentValidation();
        $this->propToModel();

        $this->news->lastUpdater()->associate(Auth::user());

        $this->news->save();
        session()->put('message', __('News successfully updated.'));

        return redirect($this->previousUrl);
    }

    public function forceWebPush(): void
    {
        $this->validate();
        $this->additionalContentValidation();
        $this->propToModel();
        $this->news->lastUpdater()->associate(Auth::user());

        \Illuminate\Support\Facades\Notification::send(
            PushSubscription::all(),
            new UpcomingNews($this->news)
        );
    }

    public function render()
    {
        return view('livewire.news.news-edit')->layout('layouts.backend');
    }
}
