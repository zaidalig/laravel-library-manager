<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\Genre;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookLoanFineTest extends TestCase
{
    use RefreshDatabase;

    protected function makeReturnedLoanWithFine(): BookLoan
    {
        $genre = Genre::create(['name' => 'Fiction', 'status' => 'active']);

        $book = Book::create([
            'isbn' => '978-0000000000',
            'title' => 'Test Book',
            'author' => 'Author',
            'genre_id' => $genre->id,
            'total_copies' => 2,
            'available_copies' => 2,
            'status' => 'active',
        ]);

        $member = Member::create([
            'member_code' => 'MBR-900',
            'name' => 'Test Member',
            'joined_at' => today(),
            'status' => 'active',
        ]);

        return BookLoan::create([
            'book_id' => $book->id,
            'member_id' => $member->id,
            'loaned_at' => today()->subDays(20),
            'due_at' => today()->subDays(10),
            'returned_at' => today()->subDays(5),
            'fine_amount' => 30.00,
            'fine_paid' => false,
            'status' => 'returned',
        ]);
    }

    public function test_librarian_can_settle_fine(): void
    {
        $user = User::create([
            'name' => 'Librarian',
            'email' => 'lib-fine@test.local',
            'password' => 'password',
            'role' => 'librarian',
            'status' => 'active',
        ]);

        $loan = $this->makeReturnedLoanWithFine();

        $this->actingAs($user)
            ->patch("/loans/{$loan->id}/settle-fine")
            ->assertRedirect();

        $loan->refresh();
        $this->assertTrue($loan->fine_paid);
        $this->assertNotNull($loan->fine_paid_at);
    }

    public function test_viewer_cannot_settle_fine(): void
    {
        $user = User::create([
            'name' => 'Viewer',
            'email' => 'view-fine@test.local',
            'password' => 'password',
            'role' => 'viewer',
            'status' => 'active',
        ]);

        $loan = $this->makeReturnedLoanWithFine();

        $this->actingAs($user)
            ->patch("/loans/{$loan->id}/settle-fine")
            ->assertForbidden();

        $this->assertFalse($loan->fresh()->fine_paid);
    }
}
