<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Filter\EventFilter;
use App\Models\MemberGroup;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Session;

trait EventFilterTrait
{
    #[Session]
    public bool $isStartNow = true;

    #[Session]
    public string $filterStart = '';

    #[Session]
    public string $filterEnd = '';

    #[Session]
    public bool $sortAsc = true;

    #[Session]
    public bool $showDisabled = false;

    #[Session]
    public ?string $memberGroupId = 'all';

    public function canFilterShowDisabled(): bool
    {
        return Auth::user()?->hasPermission(Event::EVENT_EDIT_PERMISSION) ?: false;
    }

    public function canFilterMemberGroup(): bool
    {
        return Auth::user()?->hasPermission(Event::EVENT_EDIT_PERMISSION) ?? false;
    }

    public function getEventFilter(): EventFilter
    {
        $start = new Carbon;
        if (! $this->isStartNow) {
            $start = $this->filterStart ? Carbon::parseFromDatetimeLocalInput($this->filterStart) : null;
        }

        return new EventFilter(
            $start,
            $this->filterEnd ? Carbon::parseFromDatetimeLocalInput($this->filterEnd) : null,
            $this->canFilterShowDisabled() ? $this->showDisabled : false,
            $this->getMemberGroups(),
            $this->sortAsc
        );
    }

    private function getMemberGroups(): array
    {
        if ($this->canFilterMemberGroup()) {
            if ($this->memberGroupId === 'all') {
                return [MemberGroup::$ALL];
            }
            if (is_numeric($this->memberGroupId)) {
                return [MemberGroup::query()->find($this->memberGroupId)];
            }
        }

        /** @var User $user */
        $user = Auth::user();

        return $user?->getMember()?->memberGroups()->get()->all() ?? [];
    }
}
