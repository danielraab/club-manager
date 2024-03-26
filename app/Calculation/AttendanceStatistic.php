<?php

namespace App\Calculation;

use App\Models\Event;
use App\Models\Member;
use App\Models\MemberGroup;

class AttendanceStatistic
{
    private Event $event;

    private bool $isCalculated = false;

    public int $cntIn = 0;

    public int $cntUnsure = 0;

    public int $cntOut = 0;

    public int $cntAttended = 0;

    /**
     * [
     *    "memberGroupId" => AttendanceStatisticItem
     * ]
     *
     * @var MemberGroupStatistic[]
     */
    private array $memberGroupStatList = [];

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function getMemberGroupStat(int $memberGroupId): ?MemberGroupStatistic
    {
        return $this->memberGroupStatList[$memberGroupId] ?? null;
    }

    private function accumulateToParentGroup(MemberGroup $memberGroup, MemberGroupStatistic $groupStat): void
    {
        /** @var MemberGroup $parent */
        if ($parent = $memberGroup->parent()->first()) {
            $parentStat = $this->memberGroupStatList[$parent->id] ?? new MemberGroupStatistic();
            $parentStat->in = array_unique(array_merge($parentStat->in, $groupStat->in));
            $parentStat->unsure = array_unique(array_merge($parentStat->unsure, $groupStat->unsure));
            $parentStat->out = array_unique(array_merge($parentStat->out, $groupStat->out));
            $parentStat->attended = array_unique(array_merge($parentStat->attended, $groupStat->attended));
            $this->memberGroupStatList[$parent->id] = $parentStat;

            $this->accumulateToParentGroup($parent, $parentStat);
        }
    }

    public function calculateStatistics(): self
    {
        if ($this->isCalculated) {
            return $this;
        }

        $attendances = $this->event->attendances()->get();
        foreach ($attendances as $attendance) {

            if ($attendance->poll_status === 'in') {
                $this->cntIn++;
            }
            if ($attendance->poll_status === 'unsure') {
                $this->cntUnsure++;
            }
            if ($attendance->poll_status === 'out') {
                $this->cntOut++;
            }
            if ($attendance->attended === true) {
                $this->cntAttended++;
            }

            /** @var Member $member */
            $member = $attendance->member()->first();
            foreach ($member->memberGroups()->get() as $memberGroup) {
                $groupElem = $this->memberGroupStatList[$memberGroup->id] ?? new MemberGroupStatistic();

                switch ($attendance->poll_status) {
                    case 'in':
                        $groupElem->in[] = $member->id;
                        break;
                    case 'unsure':
                        $groupElem->unsure[] = $member->id;
                        break;
                    case 'out':
                        $groupElem->out[] = $member->id;
                        break;
                }
                if ($attendance->attended) {
                    $groupElem->attended[] = $member->id;
                }
                $this->memberGroupStatList[$memberGroup->id] = $groupElem;
                $this->accumulateToParentGroup($memberGroup, $groupElem);
            }
        }
        $this->isCalculated = true;

        return $this;
    }
}
