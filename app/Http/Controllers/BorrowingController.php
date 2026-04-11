<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\ActivityLog;
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
            ->whereIn('status', ['borrowed', 'overdue'])
            ->first();

        // 3. Check borrow limit (e.g., max 5 books)
        $activeBorrowingsCount = Borrowing::where('user_id', $user->id)
            ->where('status', '!=', 'returned')
            ->count();

        if ($activeBorrowingsCount >= self::MAX_BORROW_LIMIT) {
            return back()->with('error', 'You have reached the maximum limit of ' . self::MAX_BORROW_LIMIT . ' borrowed books.');
        }

        Borrowing::create([
            'user_id' => $user->id,
        $borrowing = Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'borrowed',
        ]);

        $book->decrement('available_quantity');

        return back()->with('success', 'Book "' . $book->title . '" borrowed! Return it by ' . now()->addDays(14)->format('M d, Y'));
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'borrow',
            'model_type' => Borrowing::class,
            'model_id' => $borrowing->id,
            'description' => "Borrowed book: {$book->title}",
        ]);

        return back()->with('success', 'Book borrowed successfully. Please return by ' . now()->addDays(14)->format('Y-m-d'));
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
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'return',
            'model_type' => Borrowing::class,
            'model_id' => $borrowing->id,
            'description' => "Returned book: {$borrowing->book->title}",
        ]);

        return back()->with('success', 'Book returned successfully.');
    }

    public function myBorrowings()
    {
        $borrowings = Borrowing::with('book')->where('user_id', Auth::id())->latest()->paginate(10);
        return view('borrowings.my-borrowings', compact('borrowings'));
    }

    public function index(Request $request)
    {
        $query = Borrowing::with(['book', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('book', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        $borrowings = $query->latest()->paginate(20)->withQueryString();
        return view('borrowings.index', compact('borrowings'));
    }

    public function activities(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('description', 'like', "%{$search}%");
        }

        $activities = $query->latest()->paginate(20)->withQueryString();
        return view('borrowings.activities', compact('activities'));
    }
}
