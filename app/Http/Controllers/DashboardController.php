<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\BookLoan;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'books' => Book::count(),
            'members' => Member::count(),
            'active_loans' => BookLoan::where('status', 'borrowed')->count(),
            'overdue_loans' => BookLoan::where('status', 'borrowed')->whereDate('due_at', '<', today())->count(),
            'fines_collected' => BookLoan::where('status', 'returned')->where('fine_paid', true)->sum('fine_amount'),
        ];

        $overdueLoans = BookLoan::with(['book', 'member'])
            ->where('status', 'borrowed')
            ->whereDate('due_at', '<', today())
            ->orderBy('due_at')
            ->limit(5)
            ->get();

        $recentLoans = BookLoan::with(['book', 'member'])->latest()->limit(5)->get();
        $recentLogs = ActivityLog::with('user')->latest()->limit(8)->get();

        return view('dashboard', compact('stats', 'overdueLoans', 'recentLoans', 'recentLogs'));
    }
}
