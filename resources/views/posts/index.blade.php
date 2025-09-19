@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col">
            <h2>Posts</h2>
        </div>
        @can('create', App\Models\Post::class)
        <div class="col-auto">
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Create New Post</a>
        </div>
        @endcan
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>
                        @if($post->published)
                            <span class="badge bg-success">Published</span>
                        @else
                            <span class="badge bg-warning">Draft</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-info">View</a>
                        @can('update', $post)
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-primary">Edit</a>
                        @endcan
                        @can('publish', $post)
                            @if($post->published)
                                <form action="{{ route('posts.unpublish', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning">Unpublish</button>
                                </form>
                            @else
                                <form action="{{ route('posts.publish', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Publish</button>
                                </form>
                            @endif
                        @endcan
                        @can('delete', $post)
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
