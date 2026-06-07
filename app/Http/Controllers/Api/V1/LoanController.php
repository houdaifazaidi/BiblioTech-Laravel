<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $loans = $request->user()
            ->loans()
            ->with('book')
            ->orderByDesc('borrowed_at')
            ->get()
            ->map(fn($loan) => $this->formatLoan($loan));

        return response()->json(['data' => $loans]);
    }

    public function store(Request $request)
    {
        $request->validate(['book_id' => 'required|integer|exists:books,id']);

        $member = $request->user();
        $book   = Book::findOrFail($request->book_id);

        if ($book->available_copies < 1) {
            return response()->json(['message' => 'This book is not available.'], 422);
        }

        $alreadyBorrowing = Loan::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['active', 'overdue'])
            ->exists();

        if ($alreadyBorrowing) {
            return response()->json(['message' => 'You are already borrowing this book.'], 422);
        }

        $loan = Loan::create([
            'member_id'   => $member->id,
            'book_id'     => $book->id,
            'borrowed_at' => now(),
            'due_date'    => now()->addDays(14)->toDateString(),
            'status'      => 'active',
        ]);

        $book->decrement('available_copies');

        return response()->json([
            'message' => 'Book borrowed successfully.',
            'data'    => $this->formatLoan($loan->load('book')),
        ], 201);
    }

    public function return(Request $request, Loan $loan)
    {
        if ($loan->member_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        if (!in_array($loan->status, ['active', 'overdue'])) {
            return response()->json(['message' => 'This loan cannot be returned.'], 422);
        }

        $loan->update([
            'returned_at' => now(),
            'status'      => 'returned',
        ]);

        $loan->book->increment('available_copies');

        return response()->json([
            'message' => 'Book returned successfully.',
            'data'    => $this->formatLoan($loan->load('book')),
        ]);
    }

    private function formatLoan(Loan $loan): array
    {
        return [
            'id'             => $loan->id,
            'book_id'        => $loan->book_id,
            'book_title'     => $loan->book->title,
            'book_author'    => $loan->book->author,
            'cover_image'    => $loan->book->cover_image,
            'borrowed_at'    => $loan->borrowed_at,
            'due_date'       => $loan->due_date,
            'returned_at'    => $loan->returned_at,
            'status'         => $loan->status,
            'days_overdue'   => $loan->days_overdue,
            'penalty_amount' => $loan->penalty_amount,
            'penalty_paid'   => $loan->penalty_paid,
        ];
    }
}
