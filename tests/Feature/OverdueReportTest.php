<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OverdueReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_export_overdue_csv(): void
    {
        $owner = User::create([
            'name' => 'Owner',
            'email' => 'owner-export@test.local',
            'password' => 'password',
            'role' => 'owner',
            'status' => 'active',
        ]);

        $book = Book::create([
            'isbn' => '9780000000001',
            'title' => 'Late Book',
            'author' => 'Author',
            'total_copies' => 1,
            'available_copies' => 0,
            'status' => 'active',
        ]);

        $member = Member::create([
            'member_code' => 'M-001',
            'name' => 'Pat Member',
            'joined_at' => today()->subMonths(2),
            'status' => 'active',
        ]);

        BookLoan::create([
            'book_id' => $book->id,
            'member_id' => $member->id,
            'loaned_at' => today()->subDays(20),
            'due_at' => today()->subDays(6),
            'status' => 'borrowed',
            'user_id' => $owner->id,
        ]);

        $response = $this->actingAs($owner)->get('/reports/overdue/export');

        $response->assertOk();
        $response->assertHeader('content-disposition');
        $this->assertStringContainsString('overdue-loans.csv', $response->headers->get('content-disposition'));

        $csv = $response->streamedContent();
        $this->assertStringContainsString('Book,ISBN,Member,Loaned,Due', $csv);
        $this->assertStringContainsString('Days Late', $csv);
        $this->assertStringContainsString('Est. Fine', $csv);
        $this->assertStringContainsString('Late Book', $csv);
        $this->assertStringContainsString('9780000000001', $csv);
        $this->assertStringContainsString('Pat Member', $csv);
        $this->assertStringContainsString('60.00', $csv);
    }

    public function test_viewer_cannot_export_overdue_csv(): void
    {
        $viewer = User::create([
            'name' => 'Viewer',
            'email' => 'viewer-export@test.local',
            'password' => 'password',
            'role' => 'viewer',
            'status' => 'active',
        ]);

        $this->actingAs($viewer)->get('/reports/overdue/export')->assertForbidden();
        $this->actingAs($viewer)->get('/reports/overdue')->assertForbidden();
    }
}
