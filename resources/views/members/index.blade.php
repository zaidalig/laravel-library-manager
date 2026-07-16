@extends('layouts.app')@section('title','Members')@section('page_title','Members')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Registered library members.</p><a href="{{ route('members.create') }}" class="btn btn-primary rounded-pill">Add Member</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2">
<div class="col-md-4"><input name="search" class="form-control" placeholder="Search name, code, phone" value="{{ request('search') }}"></div>
<div class="col-md-3"><select name="status" class="form-select"><option value="">All Status</option>@foreach(['active','inactive'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></div>
<div class="col-md-4 d-flex gap-2"><button class="btn btn-dark w-100">Filter</button>@if(request()->anyFilled(['search','status']))<a href="{{ route('members.index') }}" class="btn btn-outline-secondary w-100">Clear</a>@endif</div>
</form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Code</th><th>Name</th><th>Email</th><th>Phone</th><th>Joined</th><th>Status</th><th class="text-end">Actions</th></tr></thead><tbody>
@forelse($members as $m)
<tr><td>{{ $m->member_code }}</td><td><a href="{{ route('members.show',$m) }}" class="fw-bold text-decoration-none">{{ $m->name }}</a></td><td>{{ $m->email ?? '-' }}</td><td>{{ $m->phone ?? '-' }}</td><td>{{ $m->joined_at->format('M d, Y') }}</td><td><span class="badge {{ $m->status==='active'?'bg-success-subtle text-success':'bg-danger-subtle text-danger' }}">{{ ucfirst($m->status) }}</span></td>
<td class="text-end"><a href="{{ route('members.edit',$m) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a> <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('members.destroy',$m) }}" data-name="{{ $m->name }}"><i class="fa-solid fa-trash"></i></button></td></tr>
@empty<tr><td colspan="7" class="text-center py-4 text-muted">No members found.</td></tr>@endforelse
</tbody></table></div>@if($members->hasPages())<div class="card-footer bg-white">{{ $members->links() }}</div>@endif</div>
@endsection
