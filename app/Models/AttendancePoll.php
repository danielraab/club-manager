<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendancePoll extends Model
{
    use HasFactory;
    use HasUuids;


    public const ATTENDANCE_POLL_EDIT_PERMISSION = 'attendancePollEdit';


}
