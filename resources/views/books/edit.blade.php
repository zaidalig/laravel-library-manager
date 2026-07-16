@extends('layouts.app')@section('title','Edit Book')@section('page_title','Edit Book')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('books.update',$book) }}" enctype="multipart/form-data">@csrf @method('PUT')
@include('books._form')
<div class="mt-4"><button class="btn btn-primary">Update Book</button> <a href="{{ route('books.index') }}" class="btn btn-light">Cancel</a></div></form></div>@endsection
