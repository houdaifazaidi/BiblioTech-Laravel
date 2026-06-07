<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('author', 'LIKE', "%{$search}%")
                  ->orWhere('genre', 'LIKE', "%{$search}%");
            });
        }

        $books = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'isbn'           => 'nullable|string|max:20|unique:books,isbn',
            'publisher'      => 'nullable|string|max:150',
            'published_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'genre'          => 'nullable|string|max:100',
            'description'    => 'nullable|string',
            'total_copies'   => 'required|integer|min:1',
            'cover_image'    => 'nullable|image|max:5120',
        ]);

        $data['available_copies'] = $data['total_copies'];
        $data['cover_image'] = null;
        $data['cover_image_public_id'] = null;

        if ($request->hasFile('cover_image')) {
            $uploaded = Cloudinary::uploadApi()->upload($request->file('cover_image')->getRealPath(), [
                'folder' => 'books',
            ]);
            $data['cover_image']           = $uploaded['secure_url'];
            $data['cover_image_public_id'] = $uploaded['public_id'];
        }

        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Book created successfully.');
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'isbn'           => 'nullable|string|max:20|unique:books,isbn,' . $book->id,
            'publisher'      => 'nullable|string|max:150',
            'published_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'genre'          => 'nullable|string|max:100',
            'description'    => 'nullable|string',
            'total_copies'   => 'required|integer|min:1',
            'cover_image'    => 'nullable|image|max:5120',
        ]);

        // Adjust available_copies if total_copies changed
        $diff = $data['total_copies'] - $book->total_copies;
        $data['available_copies'] = max(0, $book->available_copies + $diff);

        if ($request->hasFile('cover_image')) {
            // Delete old image from Cloudinary
            if ($book->cover_image_public_id) {
                Cloudinary::uploadApi()->destroy($book->cover_image_public_id);
            }
            // Upload new image
            $uploaded = Cloudinary::uploadApi()->upload($request->file('cover_image')->getRealPath(), [
                'folder' => 'books',
            ]);
            $data['cover_image']           = $uploaded['secure_url'];
            $data['cover_image_public_id'] = $uploaded['public_id'];
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        // Delete from Cloudinary
        if ($book->cover_image_public_id) {
            Cloudinary::uploadApi()->destroy($book->cover_image_public_id);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully.');
    }
}
