<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:150|unique:members,email',
            'password' => 'required|string|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string',
        ]);

        $member = Member::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'phone'     => $data['phone'] ?? null,
            'address'   => $data['address'] ?? null,
            'is_active' => 1,
        ]);

        $token = $member->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful.',
            'token'   => $token,
            'user'    => [
                'id'    => $member->id,
                'name'  => $member->name,
                'email' => $member->email,
                'phone' => $member->phone,
            ],
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $member = Member::where('email', $data['email'])->first();

        if (!$member || !Hash::check($data['password'], $member->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        if (!$member->is_active) {
            return response()->json(['message' => 'Your account has been deactivated.'], 403);
        }

        // Revoke old tokens and issue a fresh one
        $member->tokens()->delete();
        $token = $member->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'token'   => $token,
            'user'    => [
                'id'    => $member->id,
                'name'  => $member->name,
                'email' => $member->email,
                'phone' => $member->phone,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    public function me(Request $request)
    {
        $member = $request->user()->load([
            'loans' => fn($q) => $q->whereIn('status', ['active', 'overdue'])->with('book'),
        ]);

        return response()->json([
            'user' => [
                'id'      => $member->id,
                'name'    => $member->name,
                'email'   => $member->email,
                'phone'   => $member->phone,
                'address' => $member->address,
            ],
            'active_loans' => $member->loans->map(fn($loan) => [
                'id'             => $loan->id,
                'book_id'        => $loan->book_id,
                'book_title'     => $loan->book->title,
                'book_author'    => $loan->book->author,
                'cover_image'    => $loan->book->cover_image,
                'borrowed_at'    => $loan->borrowed_at,
                'due_date'       => $loan->due_date,
                'status'         => $loan->status,
                'days_overdue'   => $loan->days_overdue,
                'penalty_amount' => $loan->penalty_amount,
            ]),
        ]);
    }
}
