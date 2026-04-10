<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    const MAX_BORROW_LIMIT = 5;

    public function borrow(Book $book)
    {
        $user = Auth::user();

        // 1. Check if book is available
        if ($book->available_quantity <= 0) {
            return back()->with('error', 'Book is currently out of stock.');
        }

        // 2. Check if user already has this book borrowed
        $alreadyBorrowed = Borrowing::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', '!=', 'returned')
            ->exists();

        if ($alreadyBorrowed) {
            return back()->with('error', 'You currently have an active borrowing for this book.');
        }

        // 3. Check borrow limit (e.g., max 5 books)
        $activeBorrowingsCount = Borrowing::where('user_id', $user->id)
            ->where('status', '!=', 'returned')
            ->count();

        if ($activeBorrowingsCount >= self::MAX_BORROW_LIMIT) {
            return back()->with('error', 'You have reached the maximum limit of ' . self::MAX_BORROW_LIMIT . ' borrowed books.');
        }

        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'borrowed',
        ]);

        $book->decrement('available_quantity');

        return back()->with('success', 'Book "' . $book->title . '" borrowed! Return it by ' . now()->addDays(14)->format('M d, Y'));
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status === 'returned') {
            return back()->with('error', 'This record is already marked as returned.');
        }

        $isOverdue = now()->greaterThan($borrowing->due_date);
        $daysKept = $borrowing->borrowed_at->diffInDays(now());

        $borrowing->update([
            'returned_at' => now(),
            'status' => 'returned',
        ]);

        $borrowing->book->increment('available_quantity');

        $message = 'Book returned successfully. You kept it for ' . $daysKept . ' days.';
        if ($isOverdue) {
            return back()->with('success', $message . ' (Returned Late)');
        }

        return back()->with('success', $message);
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
