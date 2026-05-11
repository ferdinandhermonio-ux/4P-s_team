<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update Admin User
        \App\Models\User::updateOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        $categories = ['Science', 'Fiction', 'History', 'Technology', 'Mathematics'];
        $categoryIds = [];

        foreach ($categories as $name) {
            $category = \App\Models\Category::firstOrCreate(['name' => $name]);
            $categoryIds[$name] = $category->id;
        }

        $books = [
            [
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'category' => 'Science',
                'isbn' => '9780553380163',
                'cover_image' => 'https://picsum.photos/seed/book-1/240/360',
                'quantity' => 8,
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'category' => 'Fiction',
                'isbn' => '9780451524935',
                'cover_image' => 'https://picsum.photos/seed/book-2/240/360',
                'quantity' => 10,
            ],
            [
                'title' => 'Sapiens',
                'author' => 'Yuval Noah Harari',
                'category' => 'History',
                'isbn' => '9780062316097',
                'cover_image' => 'https://picsum.photos/seed/book-3/240/360',
                'quantity' => 7,
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'category' => 'Technology',
                'isbn' => '9780132350884',
                'cover_image' => 'https://picsum.photos/seed/book-4/240/360',
                'quantity' => 6,
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'author' => 'Andrew Hunt',
                'category' => 'Technology',
                'isbn' => '9780135957059',
                'cover_image' => 'https://picsum.photos/seed/book-5/240/360',
                'quantity' => 6,
            ],
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'category' => 'Fiction',
                'isbn' => '9780743273565',
                'cover_image' => 'https://picsum.photos/seed/book-6/240/360',
                'quantity' => 9,
            ],
            [
                'title' => 'The Art of War',
                'author' => 'Sun Tzu',
                'category' => 'History',
                'isbn' => '9781590302255',
                'cover_image' => 'https://picsum.photos/seed/book-7/240/360',
                'quantity' => 5,
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'category' => 'Science',
                'isbn' => '9780735211292',
                'cover_image' => 'https://picsum.photos/seed/book-8/240/360',
                'quantity' => 12,
            ],
            [
                'title' => 'Introduction to Algorithms',
                'author' => 'Thomas H. Cormen',
                'category' => 'Mathematics',
                'isbn' => '9780262046305',
                'cover_image' => 'https://picsum.photos/seed/book-9/240/360',
                'quantity' => 4,
            ],
            [
                'title' => 'Calculus Early Transcendentals',
                'author' => 'James Stewart',
                'category' => 'Mathematics',
                'isbn' => '9781285741550',
                'cover_image' => 'https://picsum.photos/seed/book-10/240/360',
                'quantity' => 5,
            ],
        ];

        foreach ($books as $bookData) {
            \App\Models\Book::updateOrCreate(
                ['isbn' => $bookData['isbn']],
                [
                    'title' => $bookData['title'],
                    'author' => $bookData['author'],
                    'category_id' => $categoryIds[$bookData['category']],
                    'cover_image' => $bookData['cover_image'],
                    'quantity' => $bookData['quantity'],
                    'available_quantity' => $bookData['quantity'],
                ]
            );
        }
    }
}
