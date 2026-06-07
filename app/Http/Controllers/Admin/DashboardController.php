<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books'      => Book::count(),
            'total_members'    => Member::count(),
            'active_loans'     => Loan::whereIn('status', ['active', 'overdue'])->count(),
            'overdue_loans'    => Loan::where('status', 'overdue')->count(),
            'returned_today'   => Loan::where('status', 'returned')
                                    ->whereDate('returned_at', today())
                                    ->count(),
            'available_books'  => Book::where('available_copies', '>', 0)->count(),
        ];

        $recentLoans = Loan::with(['member', 'book'])
            ->whereIn('status', ['active', 'overdue'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentLoans'));
    }
}
