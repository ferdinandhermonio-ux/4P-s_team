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
        // Create Admin User
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        $categories = ['Science', 'Fiction', 'History', 'Technology', 'Mathematics'];

        foreach ($categories as $name) {
            \App\Models\Category::create(['name' => $name]);
        }

        $science = \App\Models\Category::where('name', 'Science')->first();
        \App\Models\Book::create([
            'title' => 'Brief History of Time',
            'author' => 'Stephen Hawking',
            'category_id' => $science->id,
            'isbn' => '9780553109580',
            'quantity' => 5,
            'available_quantity' => 5,
        ]);

        $fiction = \App\Models\Category::where('name', 'Fiction')->first();
        \App\Models\Book::create([
            'title' => '1984',
            'author' => 'George Orwell',
            'category_id' => $fiction->id,
            'isbn' => '9780451524935',
            'quantity' => 10,
            'available_quantity' => 10,
        ]);
    }
}
