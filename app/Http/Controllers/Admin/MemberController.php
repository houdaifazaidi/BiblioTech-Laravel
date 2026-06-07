<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::withCount([
            'loans as active_loans_count' => fn($q) => $q->whereIn('status', ['active', 'overdue']),
        ]);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $members = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        return view('admin.members.index', compact('members'));
    }

    public function show(Member $member)
    {
        $activeLoans = $member->loans()
            ->with('book')
            ->whereIn('status', ['active', 'overdue'])
            ->orderByDesc('borrowed_at')
            ->get();

        return view('admin.members.show', compact('member', 'activeLoans'));
    }

    public function destroy(Request $request, Member $member)
    {
        $activeLoans = $member->activeLoans()->with('book')->get();

        // If request expects JSON (modal AJAX) or has action param
        if ($request->isMethod('delete') && $request->has('action')) {
            return $this->handleDeleteWithAction($request, $member, $activeLoans);
        }

        // No active loans — delete directly
        if ($activeLoans->isEmpty()) {
            $member->delete();
            return redirect()->route('admin.members.index')
                ->with('success', "Member \"{$member->name}\" deleted successfully.");
        }

        // Has active loans — return to show page with modal trigger
        return redirect()->route('admin.members.show', $member)
            ->with('show_delete_modal', true)
            ->with('active_loans_count', $activeLoans->count());
    }

    public function forceDelete(Request $request, Member $member)
    {
        $action = $request->input('action');
        $activeLoans = $member->activeLoans()->with('book')->get();

        if ($action === 'remove_books') {
            // Decrement available_copies, delete loans
            foreach ($activeLoans as $loan) {
                $loan->book->increment('available_copies');
                $loan->delete();
            }
            $member->delete();
            return redirect()->route('admin.members.index')
                ->with('success', "Member deleted. Books returned to availability.");
        }

        if ($action === 'return_books') {
            // Mark as force_returned, increment available_copies
            foreach ($activeLoans as $loan) {
                $loan->update([
                    'status'      => 'force_returned',
                    'returned_at' => now(),
                ]);
                $loan->book->increment('available_copies');
            }
            $member->delete();
            return redirect()->route('admin.members.index')
                ->with('success', "Member deleted. Loans marked as force-returned.");
        }

        return redirect()->route('admin.members.show', $member)
            ->with('error', 'Invalid action.');
    }

    private function handleDeleteWithAction(Request $request, Member $member, $activeLoans)
    {
        $action = $request->input('action');

        if ($action === 'remove_books') {
            foreach ($activeLoans as $loan) {
                $loan->book->increment('available_copies');
                $loan->delete();
            }
            $member->delete();
        } elseif ($action === 'return_books') {
            foreach ($activeLoans as $loan) {
                $loan->update(['status' => 'force_returned', 'returned_at' => now()]);
                $loan->book->increment('available_copies');
            }
            $member->delete();
        }

        return response()->json(['success' => true]);
    }
}
