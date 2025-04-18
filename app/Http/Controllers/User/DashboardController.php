<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user');
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $recentKonsultasi = Konsultasi::where('user_id', auth()->id())
            ->with('kerusakan')
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        return view('user.dashboard', compact('recentKonsultasi'));
    }
}
