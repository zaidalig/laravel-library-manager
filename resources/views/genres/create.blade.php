@extends('layouts.app')@section('title','Add Genre')@section('page_title','Add Genre')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('genres.store') }}">@csrf
<div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ old('name') }}" required></div>
<div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea></div>
<div class="mb-3"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
<button class="btn btn-primary">Save</button> <a href="{{ route('genres.index') }}" class="btn btn-light">Cancel</a></form></div>@endsection
