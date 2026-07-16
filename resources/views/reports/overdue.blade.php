@extends('layouts.app')@section('title','Overdue Report')@section('page_title','Overdue Report')
@section('content')
<div class="d-flex justify-content-between mb-4">
<p class="text-muted mb-0">Borrowed loans past their due date. Estimated fine is {{ $finePerDay }} per day late.</p>
<a href="{{ route('reports.overdue.export') }}" class="btn btn-primary rounded-pill"><i class="fa-solid fa-file-csv me-1"></i> Export CSV</a>
</div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0">
<thead class="table-light"><tr><th>Book</th><th>ISBN</th><th>Member</th><th>Loaned</th><th>Due</th><th>Days Late</th><th>Est. Fine</th></tr></thead>
<tbody>
@forelse($loans as $loan)
@php $daysLate = $loan->due_at->diffInDays(today()); @endphp
<tr>
<td class="fw-bold">{{ $loan->book->title }}</td>
<td>{{ $loan->book->isbn }}</td>
<td>{{ $loan->member->name }}</td>
<td>{{ $loan->loaned_at->format('M d, Y') }}</td>
<td>{{ $loan->due_at->format('M d, Y') }}</td>
<td><span class="badge bg-danger-subtle text-danger">{{ $daysLate }}</span></td>
<td>{{ number_format($daysLate * $finePerDay, 2) }}</td>
</tr>
@empty
<tr><td colspan="7" class="text-center py-4 text-muted">No overdue loans.</td></tr>
@endforelse
</tbody></table></div></div>
@endsection
