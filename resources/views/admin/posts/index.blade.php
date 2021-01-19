@extends('layouts.admin')

@section('title')
    Posts
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item active">Posts</li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i>
                <span>Add New Post</span>
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>
                                <img src="{{ $post->image_url }}" class="pagination-img" alt="">
                            </td>
                            <td>{{ $post->title }}</td>
                            <td class="actions-cell">
                                <a href="{{ route('admin.posts.edit', ['id' => $post->id]) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-wrench"></i>
                                    Edit
                                </a>

                                <form action="{{ route('admin.posts.delete', ['id' => $post->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

        <div class="card-footer clearfix">
            {{ $posts->links() }}
        </div>
    </div>
    <!-- /.card -->
@endsection
