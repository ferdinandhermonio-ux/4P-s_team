<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function borrow(Book $book)
    {
        if ($book->available_quantity <= 0) {
            return back()->with('error', 'Book is currently not available.');
        }

        // Check if user already borrowed this book and hasn't returned it
        $existing = Borrowing::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already borrowed this book.');
        }

        Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'borrowed',
        ]);

        $book->decrement('available_quantity');

        return back()->with('success', 'Book borrowed successfully. Please return by ' . now()->addDays(14)->format('Y-m-d'));
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status === 'returned') {
            return back()->with('error', 'Book already returned.');
        }

        $borrowing->update([
            'returned_at' => now(),
            'status' => 'returned',
        ]);

        $borrowing->book->increment('available_quantity');

        return back()->with('success', 'Book returned successfully.');
    }

    public function myBorrowings()
    {
        $borrowings = Borrowing::with('book')->where('user_id', Auth::id())->latest()->paginate(10);
        return view('borrowings.my-borrowings', compact('borrowings'));
    }

    public function index()
    {
        $borrowings = Borrowing::with(['book', 'user'])->latest()->paginate(20);
        return view('borrowings.index', compact('borrowings'));
    }
}
