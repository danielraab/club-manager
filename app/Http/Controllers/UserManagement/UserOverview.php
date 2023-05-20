<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserOverview extends Controller
{
    public function index()
    {
        return view('user-management.user-overview', ['users' => User::all()]);
    }
}
