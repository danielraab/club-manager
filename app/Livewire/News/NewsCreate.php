<?php

namespace App\Livewire\News;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\NewsForm;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
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

        Log::info('News created', [auth()->user(), $this->newsForm->news]);
        NotificationMessage::addNotificationMessage(
            new Item(__('News successfully added.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.news.news-create')->layout('layouts.backend');
    }
}
