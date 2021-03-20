@extends('layouts.admin')

@section('title')
    {{ __('pages.pages') }}
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('pages.admin') }}</a></li>
        <li class="breadcrumb-item active">{{ __('pages.pages') }}</li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.pages.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i>
                <span>
                    {{ __('pages.add_new_page') }}
                </span>
            </a>

            <form class="form-inline admin-search-form" method="GET" action="{{ route('admin.pages.index') }}">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" name="keyword" placeholder="{{ __('general.search') }}" value="{{ $keyword }}" aria-label="{{ __('general.search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>{{ __('pages.image') }}</th>
                        <th>{{ __('pages.title') }}</th>
                        <th>{{ __('general.actions') }}</th>
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
                                    {{ __('general.edit') }}
                                </a>

                                <form action="{{ route('admin.pages.delete', ['id' => $page->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">
                                        <i class="fas fa-trash"></i>
                                        {{ __('general.delete') }}
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
