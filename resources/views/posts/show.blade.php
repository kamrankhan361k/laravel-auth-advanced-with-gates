@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ $post->title }}</h2>
        <div>
            @can('update', $post)
            <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">Edit</a>
            @endcan
            @can('publish', $post)
                @if($post->published)
                    <form action="{{ route('posts.unpublish', $post) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning">Unpublish</button>
                    </form>
                @else
                    <form action="{{ route('posts.publish', $post) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">Publish</button>
                    </form>
                @endif
            @endcan
            @can('delete', $post)
            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
            @endcan
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <p class="text-muted">By {{ $post->user->name }} |
                @if($post->published)
                    <span class="badge bg-success">Published</span>
                @else
                    <span class="badge bg-warning">Draft</span>
                @endif
            </p>

            <div class="post-content">
                {!! nl2br(e($post->content)) !!}
            </div>
        </div>
    </div>

    <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Back to Posts</a>
</div>
@endsection
