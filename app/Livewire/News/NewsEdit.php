<?php

namespace App\Livewire\News;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\NewsForm;
use App\Models\News;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use App\Notifications\UpcomingNews;
use Illuminate\Support\Facades\Log;
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

        Log::info("News deleted", [auth()->user(), $this->newsForm->news]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The news has been successfully deleted.'), ItemType::WARNING));

        return redirect($this->previousUrl);
    }

    /**
     * @throws ValidationException
     */
    public function saveNewsCopy()
    {
        $this->newsForm->store();

        Log::info("News copied", [auth()->user(), $this->newsForm->news]);
        NotificationMessage::addNotificationMessage(
            new Item(__('News successfully created.'), ItemType::SUCCESS));

        return redirect(route('news.edit', ['news' => $this->newsForm->news->id]));
    }

    /**
     * @throws ValidationException
     */
    public function saveNews()
    {
        $this->newsForm->update();

        Log::info("News updated", [auth()->user(), $this->newsForm->news]);
        NotificationMessage::addNotificationMessage(
            new Item(__('News successfully updated.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    /**
     * @throws ValidationException
     */
    public function forceWebPush(): void
    {
        $this->newsForm->update();

        \Illuminate\Support\Facades\Notification::send(
            PushSubscription::all(),
            new UpcomingNews($this->newsForm->news)
        );

        Log::info("News web push forced", [auth()->user(), $this->newsForm->news]);
    }

    public function render()
    {
        return view('livewire.news.news-edit')->layout('layouts.backend');
    }
}
