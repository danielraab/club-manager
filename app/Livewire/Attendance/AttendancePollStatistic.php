<?php

declare(strict_types=1);

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use App\Models\AttendancePoll;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Arr;
use Livewire\Component;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AttendancePollStatistic extends Component
{
    public AttendancePoll $attendancePoll;

    public array $memberStatistic;

    public array $showMembers = [];

    public function mount(AttendancePoll $attendancePoll)
    {
        /** @var User $user */
        $user = auth()->user();
        if (! $attendancePoll->show_public_stats &&
            ! $user?->hasPermission(
                AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION,
                AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION)) {
            throw new NotFoundHttpException();
        }

        $this->attendancePoll = $attendancePoll;
        $this->memberStatistic = Arr::sortDesc($this->createMemberStatistic());
    }

    public function render()
    {
        return view('livewire.attendance.poll-statistic')->layout('layouts.backend');
    }

    public function toggleShowMember(int $eventId): void
    {
        $this->showMembers[$eventId] = ! ($this->showMembers[$eventId] ?? false);
    }

    private function createMemberStatistic(): array
    {
        $memberList = [];

        foreach ($this->attendancePoll->events()->get() as $event) {
            /** @var $event Event */
            foreach ($event->attendances()->get() as $attendance) {
                /** @var $attendance Attendance */
                if ($attendance->attended) {
                    $memberId = $attendance->member()->first()->id;
                    if (! isset($memberList[$memberId])) {
                        $memberList[$memberId] = 0;
                    }

                    $memberList[$memberId] = $memberList[$memberId] + 1;
                }
            }
        }

        return $memberList;
    }
}
