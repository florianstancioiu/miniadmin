@extends('layouts.admin')

@section('title')
    Pages
@endsection

@section('page-title')
    Pages
    <a href="{{ route('admin.pages.create') }}" class="btn btn-sm btn-primary">Add +</a>
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item active">Pages</li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <!-- /.card-header -->
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
                    @foreach($pages as $page)
                        <tr>
                            <td>{{ $page->id }}</td>
                            <td>
                                <img src="{{ $page->image_url }}" class="pagination-img" alt="">
                            </td>
                            <td>{{ $page->title }}</td>
                            <td class="actions-cell">
                                <a href="{{ route('admin.pages.edit', ['id' => $page->id]) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-wrench"></i>
                                    Edit
                                </a>

                                <form action="{{ route('admin.pages.delete', ['id' => $page->id]) }}" method="POST">
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
            {{ $pages->links() }}
        </div>
    </div>
    <!-- /.card -->
@endsection
