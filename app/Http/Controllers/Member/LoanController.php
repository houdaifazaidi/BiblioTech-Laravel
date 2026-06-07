<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = auth()->user()->loans()
            ->with('book')
            ->orderByDesc('borrowed_at')
            ->paginate(10);

        return view('member.loans.index', compact('loans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer|exists:books,id',
        ]);

        $member = auth()->user();
        $book   = Book::findOrFail($request->book_id);

        // Check availability
        if ($book->available_copies < 1) {
            return back()->with('error', 'This book is not available for borrowing.');
        }

        // Check if already borrowed
        $alreadyBorrowing = Loan::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['active', 'overdue'])
            ->exists();

        if ($alreadyBorrowing) {
            return back()->with('error', 'You are already borrowing this book.');
        }

        // Create loan
        Loan::create([
            'member_id'  => $member->id,
            'book_id'    => $book->id,
            'borrowed_at' => now(),
            'due_date'   => now()->addDays(14)->toDateString(),
            'status'     => 'active',
        ]);

        $book->decrement('available_copies');

        return back()->with('success', "You borrowed \"{$book->title}\" successfully. Due in 14 days.");
    }

    public function return(Request $request, Loan $loan)
    {
        // Ownership check
        if ($loan->member_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($loan->status, ['active', 'overdue'])) {
            return back()->with('error', 'This loan cannot be returned.');
        }

        $loan->update([
            'returned_at' => now(),
            'status'      => 'returned',
        ]);

        $loan->book->increment('available_copies');

        return back()->with('success', "You returned \"{$loan->book->title}\" successfully.");
    }

    public function dashboard()
    {
        $member     = auth()->user();
        $activeLoans = $member->activeLoans()->with('book')->get();
        $history    = $member->loans()->with('book')
            ->where('status', '!=', 'active')
            ->where('status', '!=', 'overdue')
            ->orderByDesc('returned_at')
            ->limit(5)
            ->get();

        return view('member.dashboard', compact('member', 'activeLoans', 'history'));
    }
}
