<?php

namespace App\Http\Livewire\InfoMessage;

use App\Models\InfoMessage;
use Illuminate\Validation\ValidationException;

trait MessageTrait
{

    public InfoMessage $info;
    public string $display_until;

    protected array $rules = [
        "info.title" => ["nullable", "string", "max:255"],
        "info.content" => ["nullable", "string"],
        "info.enabled" => ["nullable", "boolean"],
        "info.logged_in_only" => ["nullable", "boolean"],
        "display_until" => ["required", "date"]
    ];


    /**
     * @throws ValidationException
     */
    private function additionalContentValidation(): void
    {
        if (($this->info->title === null || strlen(trim($this->info->title)) === 0) &&
            ($this->info->content === null || strlen(trim($this->info->content)) === 0)
        ) {
            $titleContentEmpty = __("One of the fields (:fields) must have content.", ["fields" => __("title") . ", " . __("content")]);
            throw ValidationException::withMessages([
                "info.title" => $titleContentEmpty,
                "info.content" => $titleContentEmpty
            ]);
        }
    }
}
