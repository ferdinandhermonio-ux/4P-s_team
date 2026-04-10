<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_users' => User::count(),
            'borrowed_books' => Borrowing::where('status', 'borrowed')->count(),
            'overdue_books' => Borrowing::where('status', 'overdue')->count(),
            'categories' => Category::count(),
        ];

        return view('dashboard', compact('stats'));
    }
}
