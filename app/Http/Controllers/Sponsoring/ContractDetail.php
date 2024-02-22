<?php

namespace App\Http\Controllers\Sponsoring;

use App\Http\Controllers\Controller;
use App\Models\Sponsoring\Contract;

class ContractDetail extends Controller
{
    public function index(Contract $contract): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('sponsoring.contract-detail', [
            "contract" => $contract
        ]);
    }
}
