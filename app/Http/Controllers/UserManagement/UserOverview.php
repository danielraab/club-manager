<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserOverview extends Controller
{
    public function index()
    {
        return view("userManagement.userOverview", ["users" => User::all()]);
    }
}
