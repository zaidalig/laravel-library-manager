<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\Genre;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Library Owner', 'email' => 'owner@example.com', 'password' => 'password', 'role' => 'owner', 'status' => 'active'],
            ['name' => 'Head Librarian', 'email' => 'librarian@example.com', 'password' => 'password', 'role' => 'librarian', 'status' => 'active'],
            ['name' => 'Read Only', 'email' => 'viewer@example.com', 'password' => 'password', 'role' => 'viewer', 'status' => 'inactive'],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $genres = [
            ['name' => 'Fiction', 'description' => 'Novels and literary fiction'],
            ['name' => 'Science', 'description' => 'Science and technology'],
            ['name' => 'History', 'description' => 'Historical works and biographies'],
            ['name' => 'Children', 'description' => 'Books for young readers'],
        ];

        foreach ($genres as $genre) {
            Genre::create($genre + ['status' => 'active']);
        }

        $books = [
            ['isbn' => '978-0-14-044926-6', 'title' => 'Crime and Punishment', 'author' => 'Fyodor Dostoevsky', 'genre_id' => 1, 'published_year' => 1866, 'total_copies' => 3, 'available_copies' => 3, 'shelf_location' => 'A1'],
            ['isbn' => '978-0-452-28423-4', 'title' => '1984', 'author' => 'George Orwell', 'genre_id' => 1, 'published_year' => 1949, 'total_copies' => 4, 'available_copies' => 4, 'shelf_location' => 'A2'],
            ['isbn' => '978-0-553-38016-3', 'title' => 'A Brief History of Time', 'author' => 'Stephen Hawking', 'genre_id' => 2, 'published_year' => 1988, 'total_copies' => 2, 'available_copies' => 2, 'shelf_location' => 'B1'],
            ['isbn' => '978-0-13-468599-1', 'title' => 'The Selfish Gene', 'author' => 'Richard Dawkins', 'genre_id' => 2, 'published_year' => 1976, 'total_copies' => 1, 'available_copies' => 1, 'shelf_location' => 'B2'],
            ['isbn' => '978-0-06-231609-7', 'title' => 'Sapiens', 'author' => 'Yuval Noah Harari', 'genre_id' => 3, 'published_year' => 2011, 'total_copies' => 5, 'available_copies' => 5, 'shelf_location' => 'C1'],
            ['isbn' => '978-0-679-64115-3', 'title' => '1776', 'author' => 'David McCullough', 'genre_id' => 3, 'published_year' => 2005, 'total_copies' => 2, 'available_copies' => 2, 'shelf_location' => 'C2'],
            ['isbn' => '978-0-06-440055-8', 'title' => 'Charlotte\'s Web', 'author' => 'E. B. White', 'genre_id' => 4, 'published_year' => 1952, 'total_copies' => 3, 'available_copies' => 3, 'shelf_location' => 'D1'],
            ['isbn' => '978-0-7475-3269-9', 'title' => 'Harry Potter and the Philosopher\'s Stone', 'author' => 'J. K. Rowling', 'genre_id' => 4, 'published_year' => 1997, 'total_copies' => 6, 'available_copies' => 6, 'shelf_location' => 'D2'],
        ];

        foreach ($books as $book) {
            Book::create($book + ['status' => 'active']);
        }

        $members = [
            ['member_code' => 'MBR-001', 'name' => 'Ali Hassan', 'email' => 'ali@mail.test', 'phone' => '+92 300 1111111', 'address' => 'Street 1, Lahore', 'joined_at' => '2024-02-10'],
            ['member_code' => 'MBR-002', 'name' => 'Sara Khan', 'email' => 'sara@mail.test', 'phone' => '+92 300 2222222', 'address' => 'Street 2, Karachi', 'joined_at' => '2024-05-18'],
            ['member_code' => 'MBR-003', 'name' => 'Bilal Ahmed', 'email' => 'bilal@mail.test', 'phone' => '+92 300 3333333', 'address' => 'Street 3, Islamabad', 'joined_at' => '2025-01-05'],
            ['member_code' => 'MBR-004', 'name' => 'Nadia Iqbal', 'email' => 'nadia@mail.test', 'phone' => '+92 300 4444444', 'address' => 'Street 4, Multan', 'joined_at' => '2025-08-22'],
            ['member_code' => 'MBR-005', 'name' => 'Omar Farooq', 'email' => 'omar@mail.test', 'phone' => '+92 300 5555555', 'address' => 'Street 5, Peshawar', 'joined_at' => '2026-03-14'],
        ];

        foreach ($members as $member) {
            Member::create($member + ['status' => 'active']);
        }

        $loans = [
            // Active loans within due date
            ['book_id' => 1, 'member_id' => 1, 'loaned_at' => today()->subDays(3), 'due_at' => today()->addDays(11), 'returned_at' => null, 'fine_amount' => 0, 'status' => 'borrowed'],
            ['book_id' => 5, 'member_id' => 2, 'loaned_at' => today()->subDays(7), 'due_at' => today()->addDays(7), 'returned_at' => null, 'fine_amount' => 0, 'status' => 'borrowed'],
            // Overdue loan
            ['book_id' => 3, 'member_id' => 3, 'loaned_at' => today()->subDays(20), 'due_at' => today()->subDays(6), 'returned_at' => null, 'fine_amount' => 0, 'status' => 'borrowed'],
            // Returned on time
            ['book_id' => 8, 'member_id' => 4, 'loaned_at' => today()->subDays(30), 'due_at' => today()->subDays(16), 'returned_at' => today()->subDays(18), 'fine_amount' => 0, 'status' => 'returned'],
            // Returned late with fine (3 days * 10)
            ['book_id' => 2, 'member_id' => 5, 'loaned_at' => today()->subDays(25), 'due_at' => today()->subDays(11), 'returned_at' => today()->subDays(8), 'fine_amount' => 30.00, 'fine_paid' => false, 'status' => 'returned'],
        ];

        foreach ($loans as $loan) {
            BookLoan::create($loan + ['user_id' => 2]);

            if ($loan['status'] === 'borrowed') {
                Book::find($loan['book_id'])->decrement('available_copies');
            }
        }
    }
}
