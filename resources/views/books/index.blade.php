@extends('layouts.app')@section('title','Books')@section('page_title','Books')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Library catalog.</p><a href="{{ route('books.create') }}" class="btn btn-primary rounded-pill">Add Book</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2 align-items-center">
<div class="col-md-3"><input name="search" class="form-control" placeholder="Search title, author, ISBN" value="{{ request('search') }}"></div>
<div class="col-md-2"><select name="genre_id" class="form-select"><option value="">All Genres</option>@foreach($genres as $g)<option value="{{ $g->id }}" @selected(request('genre_id')==$g->id)>{{ $g->name }}</option>@endforeach</select></div>
<div class="col-md-2"><select name="status" class="form-select"><option value="">All Status</option>@foreach(['active','inactive'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></div>
<div class="col-md-2"><div class="form-check"><input type="checkbox" name="available" value="1" class="form-check-input" id="availableOnly" @checked(request('available'))><label class="form-check-label" for="availableOnly">Available only</label></div></div>
<div class="col-md-3 d-flex gap-2"><button class="btn btn-dark w-100">Filter</button>@if(request()->anyFilled(['search','genre_id','status','available']))<a href="{{ route('books.index') }}" class="btn btn-outline-secondary w-100">Clear</a>@endif</div>
</form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th style="width:56px"></th><th>ISBN</th><th>Title</th><th>Author</th><th>Genre</th><th>Copies</th><th>Status</th><th class="text-end">Actions</th></tr></thead><tbody>
@forelse($books as $b)
<tr>
<td>@if($b->cover_path)<img src="{{ $b->coverUrl() }}" alt="" class="book-cover-thumb rounded">@else<span class="book-cover-placeholder rounded d-inline-flex align-items-center justify-content-center text-muted"><i class="fa-solid fa-book"></i></span>@endif</td>
<td>{{ $b->isbn }}</td><td><a href="{{ route('books.show',$b) }}" class="fw-bold text-decoration-none">{{ $b->title }}</a></td><td>{{ $b->author }}</td><td>{{ $b->genre?->name ?? '-' }}</td><td><span class="badge {{ $b->isAvailable()?'bg-success-subtle text-success':'bg-danger-subtle text-danger' }}">{{ $b->available_copies }} / {{ $b->total_copies }}</span></td><td><span class="badge {{ $b->status==='active'?'bg-success-subtle text-success':'bg-danger-subtle text-danger' }}">{{ ucfirst($b->status) }}</span></td>
<td class="text-end"><a href="{{ route('books.edit',$b) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a> <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('books.destroy',$b) }}" data-name="{{ $b->title }}"><i class="fa-solid fa-trash"></i></button></td></tr>
@empty<tr><td colspan="8" class="text-center py-4 text-muted">No books found.</td></tr>@endforelse
</tbody></table></div>@if($books->hasPages())<div class="card-footer bg-white">{{ $books->links() }}</div>@endif</div>
@endsection
