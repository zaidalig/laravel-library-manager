@extends('layouts.app')@section('title',$member->name)@section('page_title',$member->name)
@section('content')
<div class="row g-4">
<div class="col-lg-4"><div class="card p-4 border-0 shadow-sm"><h4 class="fw-bold mb-1">{{ $member->name }}</h4><p class="text-muted mb-2">{{ $member->member_code }}</p>
<p class="mb-1"><i class="fa-regular fa-envelope me-2 text-muted"></i>{{ $member->email ?? '-' }}</p>
<p class="mb-1"><i class="fa-solid fa-phone me-2 text-muted"></i>{{ $member->phone ?? '-' }}</p>
<p class="mb-1"><i class="fa-solid fa-location-dot me-2 text-muted"></i>{{ $member->address ?? '-' }}</p>
<p class="mb-3"><i class="fa-solid fa-calendar me-2 text-muted"></i>Joined {{ $member->joined_at->format('M d, Y') }}</p>
<a href="{{ route('members.edit',$member) }}" class="btn btn-sm btn-outline-primary">Edit Member</a></div></div>
<div class="col-lg-8">
<div class="card card-table border-0 mb-4"><div class="card-header bg-white fw-bold">Current Loans</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Book</th><th>Loaned</th><th>Due</th><th>Status</th></tr></thead><tbody>@forelse($currentLoans as $l)<tr><td>{{ $l->book->title }}</td><td>{{ $l->loaned_at->format('M d, Y') }}</td><td>{{ $l->due_at->format('M d, Y') }}</td><td><span class="badge {{ $l->isOverdue()?'bg-danger-subtle text-danger':'bg-warning-subtle text-warning' }}">{{ $l->isOverdue() ? 'Overdue' : 'Borrowed' }}</span></td></tr>@empty<tr><td colspan="4" class="text-center py-3 text-muted">No current loans.</td></tr>@endforelse</tbody></table></div></div>
<div class="card card-table border-0"><div class="card-header bg-white fw-bold">Past Loans</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Book</th><th>Loaned</th><th>Returned</th><th>Fine</th></tr></thead><tbody>@forelse($pastLoans as $l)<tr><td>{{ $l->book->title }}</td><td>{{ $l->loaned_at->format('M d, Y') }}</td><td>{{ $l->returned_at?->format('M d, Y') ?? '-' }}</td><td>{{ number_format($l->fine_amount,2) }}</td></tr>@empty<tr><td colspan="4" class="text-center py-3 text-muted">No past loans.</td></tr>@endforelse</tbody></table></div></div>
</div>
</div>
@endsection
