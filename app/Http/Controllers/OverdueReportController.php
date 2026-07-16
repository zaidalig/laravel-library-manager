<?php

namespace App\Http\Controllers;

use App\Models\BookLoan;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OverdueReportController extends Controller
{
    public function index()
    {
        $loans = $this->overdueLoans();
        $finePerDay = BookLoanController::FINE_PER_DAY;

        return view('reports.overdue', compact('loans', 'finePerDay'));
    }

    public function export(): StreamedResponse
    {
        $loans = $this->overdueLoans();
        $filename = 'overdue-loans.csv';

        return response()->streamDownload(function () use ($loans) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Book', 'ISBN', 'Member', 'Loaned', 'Due', 'Days Late', 'Est. Fine']);

            foreach ($loans as $loan) {
                $daysLate = $loan->due_at->diffInDays(today());
                fputcsv($handle, [
                    $loan->book->title,
                    $loan->book->isbn,
                    $loan->member->name,
                    $loan->loaned_at->format('Y-m-d'),
                    $loan->due_at->format('Y-m-d'),
                    $daysLate,
                    number_format($daysLate * BookLoanController::FINE_PER_DAY, 2, '.', ''),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function overdueLoans()
    {
        return BookLoan::with(['book', 'member'])
            ->where('status', 'borrowed')
            ->whereDate('due_at', '<', today())
            ->orderBy('due_at')
            ->get();
    }
}
