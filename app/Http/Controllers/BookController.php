<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('genre');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('genre_id')) {
            $query->where('genre_id', $request->input('genre_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('available')) {
            $query->where('available_copies', '>', 0);
        }

        $books = $query->latest()->paginate(10)->withQueryString();
        $genres = Genre::where('status', 'active')->orderBy('name')->get();

        return view('books.index', compact('books', 'genres'));
    }

    public function create()
    {
        $genres = Genre::where('status', 'active')->orderBy('name')->get();

        return view('books.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        $book = Book::create($data);

        return redirect()->route('books.index')
            ->with('success', "Book \"{$book->title}\" created.");
    }

    public function show(Book $book)
    {
        $book->load([
            'genre',
            'loans' => fn ($q) => $q->with(['member', 'user'])->latest('loaned_at')->limit(15),
        ]);

        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $genres = Genre::where('status', 'active')->orderBy('name')->get();

        return view('books.edit', compact('book', 'genres'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $this->validated($request, $book->id);

        if ($request->hasFile('cover')) {
            if ($book->cover_path) {
                Storage::disk('public')->delete($book->cover_path);
            }
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        $book->update($data);

        return redirect()->route('books.show', $book)
            ->with('success', "Book \"{$book->title}\" updated.");
    }

    public function destroy(Book $book)
    {
        $title = $book->title;

        if ($book->cover_path) {
            Storage::disk('public')->delete($book->cover_path);
        }

        $book->delete();

        return redirect()->route('books.index')
            ->with('success', "Book \"{$title}\" deleted.");
    }

    private function validated(Request $request, ?int $bookId = null): array
    {
        $data = $request->validate([
            'isbn' => 'required|string|max:32|unique:books,isbn,'.($bookId ?? 'NULL'),
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre_id' => 'nullable|exists:genres,id',
            'published_year' => 'nullable|integer|min:1000|max:'.date('Y'),
            'total_copies' => 'required|integer|min:1',
            'available_copies' => 'required|integer|min:0|lte:total_copies',
            'shelf_location' => 'nullable|string|max:64',
            'cover' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        unset($data['cover']);

        return $data;
    }
}
