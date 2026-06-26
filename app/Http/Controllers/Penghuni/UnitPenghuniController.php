<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use Illuminate\Support\Facades\Auth;

class UnitPenghuniController extends Controller
{
    public function index()
    {
        $penghuni = Penghuni::with(['unit.lantai'])
            ->where('user_id', Auth::id())
            ->first();

        return view('penghuni.unit', compact('penghuni'));
    }
}
