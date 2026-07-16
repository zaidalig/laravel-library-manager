@extends('layouts.app')@section('title','Add Member')@section('page_title','Add Member')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('members.store') }}">@csrf
@include('members._form')
<div class="mt-4"><button class="btn btn-primary">Save Member</button> <a href="{{ route('members.index') }}" class="btn btn-light">Cancel</a></div></form></div>@endsection
