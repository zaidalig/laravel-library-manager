@extends('layouts.app')@section('title','Loans')@section('page_title','Book Loans')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Track borrowed and returned books.</p><a href="{{ route('loans.create') }}" class="btn btn-primary rounded-pill">New Loan</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2">
<div class="col-md-3"><select name="status" class="form-select form-select-sm form-select-compact"><option value="">All Statuses</option>@foreach(['borrowed','returned'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></div>
<div class="col-md-3"><select name="member_id" class="form-select form-select-sm form-select-compact"><option value="">All Members</option>@foreach($members as $m)<option value="{{ $m->id }}" @selected(request('member_id')==$m->id)>{{ $m->name }}</option>@endforeach</select></div>
<div class="col-md-3"><select name="book_id" class="form-select form-select-sm form-select-compact"><option value="">All Books</option>@foreach($books as $b)<option value="{{ $b->id }}" @selected(request('book_id')==$b->id)>{{ $b->title }}</option>@endforeach</select></div>
<div class="col-md-3 d-flex gap-2"><button class="btn btn-dark w-100">Filter</button>@if(request()->anyFilled(['status','member_id','book_id']))<a href="{{ route('loans.index') }}" class="btn btn-outline-secondary w-100">Clear</a>@endif</div>
</form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Book</th><th>Member</th><th>Loaned</th><th>Due</th><th>Returned</th><th>Fine</th><th>Status</th><th class="text-end">Actions</th></tr></thead><tbody>
@forelse($loans as $loan)
<tr><td class="fw-bold">{{ $loan->book->title }}</td><td>{{ $loan->member->name }}</td><td>{{ $loan->loaned_at->format('M d, Y') }}</td><td>{{ $loan->due_at->format('M d, Y') }}</td><td>{{ $loan->returned_at?->format('M d, Y') ?? '-' }}</td><td>@if($loan->fine_amount>0)${{ number_format($loan->fine_amount,2) }}@if($loan->fine_paid) <span class="badge bg-success-subtle text-success">Paid</span>@else <span class="badge bg-warning-subtle text-warning">Unpaid</span>@endif @else - @endif</td>
<td><span class="badge {{ $loan->status==='returned'?'bg-success-subtle text-success':($loan->isOverdue()?'bg-danger-subtle text-danger':'bg-warning-subtle text-warning') }}">{{ $loan->isOverdue() ? 'Overdue' : ucfirst($loan->status) }}</span></td>
<td class="text-end"><span class="table-actions">
@if($loan->status==='borrowed')
<form method="POST" action="{{ route('loans.return',$loan) }}" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-success" title="Return"><i class="fa-solid fa-rotate-left"></i> Return</button></form>
@else
@if($loan->fine_amount>0 && !$loan->fine_paid)
<form method="POST" action="{{ route('loans.settle-fine',$loan) }}" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-success" title="Mark Fine Paid"><i class="fa-solid fa-dollar-sign"></i> Pay Fine</button></form>
@endif
<button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('loans.destroy',$loan) }}" data-name="loan of {{ $loan->book->title }}"><i class="fa-solid fa-trash"></i></button>
@endif
</span></td></tr>
@empty<tr><td colspan="8" class="text-center py-4 text-muted">No loans found.</td></tr>@endforelse
</tbody></table></div><x-table-pagination :paginator="$loans" :sorts="['loaned_at'=>'Loaned','due_at'=>'Due','returned_at'=>'Returned','fine_amount'=>'Fine','status'=>'Status','created_at'=>'Created']" /></div>
@endsection
