<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CalendarLinks extends Component
{
    public const CALENDAR_TOKEN_NAME = 'calendarLink';

    public function deleteLink(int $id): void
    {
        /** @var User $user */
        $user = auth()->user();

        $user->tokens()->find($id)->delete();
        Log::info('Calendar link deleted', [auth()->user()]);
    }

    public function createLink(): void
    {
        /** @var User $user */
        $user = auth()->user();

        $token = $user->createToken(self::CALENDAR_TOKEN_NAME)->accessToken;

        Log::info('New user calendar link created', [auth()->user()]);
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        /** @var User $user */
        $user = auth()->user();

        return view('livewire.profile.calendar-links', [
            'tokenLinks' => $user->tokens()->where('name', self::CALENDAR_TOKEN_NAME)->get(),
        ]);
    }
}
