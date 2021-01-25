@extends('layouts.main')

@section('content')

    <div class="container mb-5">
        
        <h1>Create new post</h1>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            
        </form>

    </div>

@endsection