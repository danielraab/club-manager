<?php

namespace App\Http\Livewire\News;

use App\Models\News;
use Illuminate\Validation\ValidationException;

trait NewsTrait
{

    public News $news;
    public string $display_until;

    protected array $rules = [
        "news.title" => ["nullable", "string", "max:255"],
        "news.content" => ["nullable", "string"],
        "news.enabled" => ["nullable", "boolean"],
        "news.logged_in_only" => ["nullable", "boolean"],
        "display_until" => ["required", "date"]
    ];


    /**
     * @throws ValidationException
     */
    private function additionalContentValidation(): void
    {
        if (($this->news->title === null || strlen(trim($this->news->title)) === 0) &&
            ($this->news->content === null || strlen(trim($this->news->content)) === 0)
        ) {
            $titleContentEmpty = __("One of the fields (:fields) must have content.", ["fields" => __("title") . ", " . __("content")]);
            throw ValidationException::withMessages([
                "news.title" => $titleContentEmpty,
                "news.content" => $titleContentEmpty
            ]);
        }
    }
}
