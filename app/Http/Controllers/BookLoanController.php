<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\Member;
use Illuminate\Http\Request;

class BookLoanController extends Controller
{
    public const FINE_PER_DAY = 10;

    public function index(Request $request)
    {
        $query = BookLoan::with(['book', 'member', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('member_id')) {
            $query->where('member_id', $request->input('member_id'));
        }

        if ($request->filled('book_id')) {
            $query->where('book_id', $request->input('book_id'));
        }

        [$perPage, $sort, $direction] = $this->listQueryParams($request, ['loaned_at', 'due_at', 'returned_at', 'fine_amount', 'status', 'created_at'], 'created_at');
        $loans = $query->orderBy($sort, $direction)->paginate($perPage)->withQueryString();
        $members = Member::where('status', 'active')->orderBy('name')->get();
        $books = Book::where('status', 'active')->orderBy('title')->get();

        return view('loans.index', compact('loans', 'members', 'books'));
    }

    public function create()
    {
        $books = Book::where('status', 'active')->orderBy('title')->get();
        $members = Member::where('status', 'active')->orderBy('name')->get();

        return view('loans.create', compact('books', 'members'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'loaned_at' => 'required|date',
            'due_at' => 'required|date|after_or_equal:loaned_at',
        ]);

        $book = Book::findOrFail($data['book_id']);

        if (! $book->isAvailable()) {
            return back()->with('error', "No available copies of \"{$book->title}\".")->withInput();
        }

        $book->decrement('available_copies');

        BookLoan::create($data + ['status' => 'borrowed', 'user_id' => auth()->id()]);

        return redirect()->route('loans.index')
            ->with('success', "\"{$book->title}\" loaned out.");
    }

    public function returnBook(BookLoan $loan)
    {
        if ($loan->status === 'returned') {
            return back()->with('error', 'This loan has already been returned.');
        }

        $daysLate = $loan->due_at->lt(today()) ? $loan->due_at->diffInDays(today()) : 0;

        $loan->update([
            'returned_at' => today(),
            'fine_amount' => $daysLate * self::FINE_PER_DAY,
            'status' => 'returned',
        ]);

        $loan->book->increment('available_copies');

        $message = "\"{$loan->book->title}\" returned.";
        if ($daysLate > 0) {
            $message .= ' Fine: '.number_format($daysLate * self::FINE_PER_DAY, 2).' ('.$daysLate.' day(s) late).';
        }

        return back()->with('success', $message);
    }

    public function settleFine(BookLoan $loan)
    {
        if ($loan->status !== 'returned') {
            return back()->with('error', 'Only returned loans can have fines settled.');
        }

        if ($loan->fine_amount <= 0) {
            return back()->with('error', 'This loan has no fine to settle.');
        }

        if ($loan->fine_paid) {
            return back()->with('error', 'Fine has already been paid.');
        }

        $loan->update([
            'fine_paid' => true,
            'fine_paid_at' => now(),
        ]);

        return back()->with('success', 'Fine of $'.number_format($loan->fine_amount, 2).' marked as paid.');
    }

    public function destroy(BookLoan $loan)
    {
        if ($loan->status !== 'returned') {
            return back()->with('error', 'Only returned loans can be deleted.');
        }

        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Loan record deleted.');
    }
}
