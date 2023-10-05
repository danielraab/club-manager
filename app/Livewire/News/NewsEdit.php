<?php

namespace App\Livewire\News;

use App\Livewire\Forms\NewsForm;
use App\Models\News;
use App\Notifications\UpcomingEvent;
use App\Notifications\UpcomingNews;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use NotificationChannels\WebPush\PushSubscription;

class NewsEdit extends Component
{
    public NewsForm $newsForm;
    public string $previousUrl;

    public function mount(News $news): void
    {
        $this->newsForm->setNewsModel($news);
        $this->previousUrl = url()->previous();
    }

    public function deleteNews()
    {
        $this->newsForm->delete();
        session()->put('message', __('The news has been successfully deleted.'));

        return redirect($this->previousUrl);
    }

    /**
     * @throws ValidationException
     */
    public function saveNewsCopy()
    {
        $this->newsForm->store();

        session()->put('message', __('News successfully created.'));
        return redirect(route('news.edit', ['news' => $this->newsForm->news->id]));
    }

    /**
     * @throws ValidationException
     */
    public function saveNews()
    {
        $this->newsForm->update();

        session()->put('message', __('News successfully updated.'));
        return redirect($this->previousUrl);
    }

    /**
     * @throws ValidationException
     */
    public function forceWebPush(): void
    {
        $this->newsForm->validate();
        $this->newsForm->additionalContentValidation();

        \Illuminate\Support\Facades\Notification::send(
            PushSubscription::all(),
            new UpcomingNews($this->newsForm->news)
        );
    }

    public function render()
    {
        return view('livewire.news.news-edit')->layout('layouts.backend');
    }
}
