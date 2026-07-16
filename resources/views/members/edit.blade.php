@extends('layouts.app')@section('title','Edit Member')@section('page_title','Edit Member')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('members.update',$member) }}">@csrf @method('PUT')
@include('members._form')
<div class="mt-4"><button class="btn btn-primary">Update Member</button> <a href="{{ route('members.index') }}" class="btn btn-light">Cancel</a></div></form></div>@endsection
