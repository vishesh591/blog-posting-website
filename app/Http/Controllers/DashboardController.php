<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardService $dashboard)
    {
    }

    public function index(): View
    {
        return view('dashboard.index', [
            'stats' => $this->dashboard->overview(auth()->id(), auth()->user()->role),
        ]);
    }

    public function notifications(): View
    {
        return view('dashboard.notifications', [
            'notifications' => auth()->user()->notifications()->latest()->paginate(15),
        ]);
    }

    public function markNotificationsRead(): RedirectResponse
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Notifications marked as read.');
    }
}
