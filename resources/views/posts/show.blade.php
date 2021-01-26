@extends('layouts.main')

@section('content')

    <div class="container mb-5">
        
        <h1>{{ $post->title }}</h1>
        <div>Last updated: {{ $post->updated_at->diffForHumans() }}</div>
        <div class="actions mt-2 mb-5">
            <a class="btn btn-primary"href="{{ route('posts.edit', $post->slug) }}">Edit</a>
            <form class="d-inline" action="{{ route('posts.destroy', $post->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <input class="btn btn-danger" type="submit" value="Delete">
            </form>
        </div>

        @if(!empty($post->path_img))
            <img src="{{ asset('storage/' . $post->path_img) }}" alt="{{ $post->title }}">
        @else
            <img src="{{ asset('img/no-image.png') }}" alt="{{ $post->title }}">
        @endif

        <div class="text mb-5 mt-5">{{ $post->body }}</div>

    </div>

@endsection