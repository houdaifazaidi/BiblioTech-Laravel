<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // Fulltext search
        if ($search = $request->input('search')) {
            $query->whereRaw(
                'MATCH(title, author, genre) AGAINST(? IN BOOLEAN MODE)',
                [$search . '*']
            );
        }

        // Genre filter
        if ($genre = $request->input('genre')) {
            $query->where('genre', $genre);
        }

        // Author filter
        if ($author = $request->input('author')) {
            $query->where('author', 'LIKE', "%{$author}%");
        }

        // Availability filter
        if ($request->boolean('available')) {
            $query->where('available_copies', '>', 0);
        }

        $books = $query->orderByDesc('created_at')->paginate(12)->withQueryString();

        $genres = Book::select('genre')->whereNotNull('genre')->distinct()->orderBy('genre')->pluck('genre');

        return view('member.books.index', compact('books', 'genres'));
    }

    public function show(Book $book)
    {
        $alreadyBorrowed = false;
        if (auth()->check()) {
            $alreadyBorrowed = auth()->user()->activeLoans()
                ->where('book_id', $book->id)
                ->exists();
        }
        return view('member.books.show', compact('book', 'alreadyBorrowed'));
    }
}
