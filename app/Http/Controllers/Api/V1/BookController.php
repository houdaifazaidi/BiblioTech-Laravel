<?php

namespace App\Http\Controllers\Api\V1;

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
        if ($request->input('available') == '1') {
            $query->where('available_copies', '>', 0);
        }

        $books = $query->orderByDesc('created_at')->paginate(12);

        return response()->json([
            'data' => $books->items(),
            'meta' => [
                'current_page' => $books->currentPage(),
                'last_page'    => $books->lastPage(),
                'per_page'     => $books->perPage(),
                'total'        => $books->total(),
            ],
        ]);
    }

    public function show(Book $book)
    {
        return response()->json(['data' => $book]);
    }
}
