@extends('layouts.app')@section('title','New Loan')@section('page_title','New Loan')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('loans.store') }}">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Book</label><select name="book_id" class="form-select" required><option value="">Select a book</option>@foreach($books as $b)<option value="{{ $b->id }}" @selected(old('book_id')==$b->id) @disabled(! $b->isAvailable())>{{ $b->title }} — {{ $b->available_copies }} available</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Member</label><select name="member_id" class="form-select" required><option value="">Select a member</option>@foreach($members as $m)<option value="{{ $m->id }}" @selected(old('member_id')==$m->id)>{{ $m->name }} ({{ $m->member_code }})</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Loan Date</label><input type="date" name="loaned_at" class="form-control" value="{{ old('loaned_at', date('Y-m-d')) }}" required></div>
<div class="col-md-6"><label class="form-label">Due Date</label><input type="date" name="due_at" class="form-control" value="{{ old('due_at', now()->addDays(14)->format('Y-m-d')) }}" required></div>
</div>
<div class="mt-4"><button class="btn btn-primary">Create Loan</button> <a href="{{ route('loans.index') }}" class="btn btn-light">Cancel</a></div></form></div>@endsection
