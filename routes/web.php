<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin,librarian'])->group(function () {
    Route::resource('books', BookController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('/activities', [BorrowingController::class, 'activities'])->name('borrowings.activities');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Borrowing routes
    Route::post('/books/{book}/borrow', [BorrowingController::class, 'borrow'])->name('books.borrow');
    Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');
    Route::get('/my-borrowings', [BorrowingController::class, 'myBorrowings'])->name('my.borrowings');
});

require __DIR__.'/auth.php';
