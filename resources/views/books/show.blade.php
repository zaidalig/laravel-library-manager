@extends('layouts.app')@section('title',$book->title)@section('page_title',$book->title)
@section('content')
<div class="row g-4">
<div class="col-lg-4"><div class="card p-4 border-0 shadow-sm">
@if($book->cover_path)<img src="{{ $book->coverUrl() }}" alt="{{ $book->title }} cover" class="book-cover-lg rounded border mb-3 w-100">@else<div class="book-cover-lg-placeholder rounded border mb-3 d-flex align-items-center justify-content-center text-muted"><i class="fa-solid fa-book fa-3x"></i></div>@endif
<h4 class="fw-bold mb-1">{{ $book->title }}</h4><p class="text-muted mb-2">{{ $book->isbn }} | {{ $book->author }}</p>
<p class="mb-1"><i class="fa-solid fa-tags me-2 text-muted"></i>{{ $book->genre?->name ?? 'No genre' }}</p>
<p class="mb-1"><i class="fa-solid fa-calendar me-2 text-muted"></i>Published {{ $book->published_year ?? '-' }}</p>
<p class="mb-1"><i class="fa-solid fa-copy me-2 text-muted"></i>{{ $book->available_copies }} of {{ $book->total_copies }} copies available</p>
<p class="mb-3"><i class="fa-solid fa-location-dot me-2 text-muted"></i>Shelf {{ $book->shelf_location ?? '-' }}</p>
<a href="{{ route('books.edit',$book) }}" class="btn btn-sm btn-outline-primary">Edit Book</a></div></div>
<div class="col-lg-8">
<div class="card card-table border-0"><div class="card-header bg-white fw-bold">Loan History</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Member</th><th>Loaned</th><th>Due</th><th>Returned</th><th>Fine</th><th>Status</th></tr></thead><tbody>@forelse($book->loans as $l)<tr><td>{{ $l->member->name }}</td><td>{{ $l->loaned_at->format('M d, Y') }}</td><td>{{ $l->due_at->format('M d, Y') }}</td><td>{{ $l->returned_at?->format('M d, Y') ?? '-' }}</td><td>{{ number_format($l->fine_amount,2) }}</td><td><span class="badge {{ $l->status==='returned'?'bg-success-subtle text-success':($l->isOverdue()?'bg-danger-subtle text-danger':'bg-warning-subtle text-warning') }}">{{ $l->isOverdue() ? 'Overdue' : ucfirst($l->status) }}</span></td></tr>@empty<tr><td colspan="6" class="text-center py-3 text-muted">No loans yet.</td></tr>@endforelse</tbody></table></div></div>
</div>
</div>
@endsection
