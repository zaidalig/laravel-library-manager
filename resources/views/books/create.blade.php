@extends('layouts.app')@section('title','Add Book')@section('page_title','Add Book')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">@csrf
@include('books._form')
<div class="mt-4"><button class="btn btn-primary">Save Book</button> <a href="{{ route('books.index') }}" class="btn btn-light">Cancel</a></div></form></div>@endsection
