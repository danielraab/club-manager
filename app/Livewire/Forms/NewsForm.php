<?php

namespace App\Livewire\Forms;

use App\Models\News;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class NewsForm extends Form
{
    public ?News $news;

    #[Validate('max:255')]
    public ?string $title = null;

    public ?string $content = null;

    public bool $enabled = true;

    public bool $logged_in_only = false;

    #[Validate('required|date')]
    public string $display_until;

    public function setNewsModel(News $news): void
    {
        $this->news = $news;
        $this->title = $news->title;
        $this->content = $news->content;
        $this->enabled = $news->enabled;
        $this->logged_in_only = $news->logged_in_only;
        $this->display_until = $news->display_until->formatDatetimeLocalInput();
    }

    /**
     * @throws ValidationException
     */
    public function store(): void
    {
        $this->validate();
        $this->additionalContentValidation();

        $this->news = News::create([
            'display_until' => Carbon::parseFromDatetimeLocalInput($this->display_until),
            ...$this->except('news', 'display_until'),
        ]);

        $this->news->creator()->associate(Auth::user());
        $this->news->lastUpdater()->associate(Auth::user());

        $this->news->save();
    }

    public function delete(): void
    {
        $this->news?->delete();
    }

    /**
     * @throws ValidationException
     */
    public function update(): void
    {
        $this->validate();
        $this->additionalContentValidation();

        $this->news->update([
            ...$this->except('news', 'display_until'),
            'display_until' => Carbon::parseFromDatetimeLocalInput($this->display_until),
        ]);
        $this->news->lastUpdater()->associate(Auth::user());
        $this->news->save();
    }

    /**
     * @throws ValidationException
     */
    public function additionalContentValidation(): void
    {
        if (($this->title === null || strlen(trim($this->title)) === 0) &&
            ($this->content === null || strlen(trim($this->content)) === 0)
        ) {
            $titleContentEmpty = __('One of the fields (:fields) must have content.', ['fields' => __('title').', '.__('content')]);
            throw ValidationException::withMessages([
                'newsForm.title' => $titleContentEmpty,
                'newsForm.content' => $titleContentEmpty,
            ]);
        }
    }
}
