@extends('layouts.admin')

@section('title')
    {{ __('pages.pages') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            @can('create pages')
                <a href="{{ route('admin.pages.create') }}" class="btn btn-sm btn-primary btn-add-new">
                    <i class="fas fa-plus"></i>
                    <span>
                        {{ __('general.add_new') }}
                    </span>
                </a>
            @endcan

            <form class="form-inline admin-search-form" method="GET" action="{{ route('admin.pages.index') }}">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" name="keyword" placeholder="{{ __('general.search') }}" value="{{ $keyword }}" aria-label="{{ __('general.search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-navbar btn-search" type="submit">
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
                        <th>{{ __('general.image') }}</th>
                        <th>{{ __('general.title') }}</th>
                        <th>{{ __('general.author') }}</th>
                        <th>{{ __('general.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td>
                                @if($page->image)
                                    <img src="{{ $page->image_url }}" class="pagination-img" alt="">
                                @else
                                    <img src="{{ url('img/no-image.png') }}" class="pagination-img" alt="">
                                @endif
                            </td>
                            <td>{{ $page->title }}</td>
                            <td>{{ $page->user->getFullName() }}</td>
                            <td class="actions-cell">
                                @can('update', $page)
                                    <a href="{{ route('admin.pages.edit', ['page' => $page->id]) }}" class="btn btn-primary btn-sm btn-edit" title="{{ __('general.edit') }}">
                                        <i class="fas fa-wrench"></i>
                                    </a>
                                @endcan
                                @can('delete', $page)
                                    <form action="{{ route('admin.pages.destroy', ['page' => $page->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="page" value="{{ $page->id }}">
                                        <button class="btn btn-danger btn-sm btn-delete" type="submit" title="{{ __('general.delete') }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $pages->links() }}
        </div>
    </div>
@endsection
