<?php

namespace Tests\Feature\PagePermission;

use App\Models\Attendance;
use App\Models\AttendancePoll;
use App\Models\UserPermission;

class AttendanceTest extends TestPagePermission
{
    protected function getPermissionsToTest(): array
    {
        return [
            UserPermission::ADMIN_USER_PERMISSION,
            Attendance::ATTENDANCE_SHOW_PERMISSION,
            Attendance::ATTENDANCE_EDIT_PERMISSION,
            AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION,
            AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION,
        ];
    }

    public static function routesWithPermissionProvider(): array
    {
        return [
//            ['/events/event/1/attendance', [Attendance::ATTENDANCE_SHOW_PERMISSION, Attendance::ATTENDANCE_EDIT_PERMISSION]],
//            ['/events/event/1/attendance/edit', [Attendance::ATTENDANCE_EDIT_PERMISSION]],
//            ['/attendancePolls/1/public', null],
//            ['/attendancePolls/1/index', null],

            ['/attendancePolls', [AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION, AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION]],

            ['/attendancePolls/create', [AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION]],
//            ['/attendancePolls/1/edit', [AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION]],
        ];
    }
}
