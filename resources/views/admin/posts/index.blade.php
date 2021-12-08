@extends('layouts.admin')

@section('title')
    {{ __('posts.posts') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            @can('create posts')
                <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-primary btn-add-new">
                    <i class="fas fa-plus"></i>
                    <span>{{ __('general.add_new') }}</span>
                </a>
            @endcan

            <form class="form-inline admin-search-form" method="GET" action="{{ route('admin.posts.index') }}">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" name="keyword" value="{{ $keyword }}" placeholder="{{ __('general.search') }}" aria-label="{{ __('general.search') }}">
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
                        <th>{{ __('general.created_at') }}</th>
                        <th>{{ __('general.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>
                                @if($post->image)
                                    <img src="{{ $post->image_url }}" class="pagination-img" alt="" data-toggle="tooltip" data-placement="top" data-html="true" title="<img class='tooltip-img' src='{{ $post->image_url }}'>">
                                @else
                                    <img src="{{ url('img/no-image.png') }}" class="pagination-img" alt="" data-toggle="tooltip" data-placement="top" data-html="true" title="<img class='tooltip-img' src='{{ url('img/no-image.png') }}'>">
                                @endif
                            </td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->user->getFullName() }}</td>
                            <td>{{ $post->created_at->toFormattedDateString() }}</td>
                            <td class="actions-cell">
                                @can('update', $post)
                                    <a href="{{ route('admin.posts.edit', ['post' => $post->id]) }}" class="btn btn-primary btn-sm btn-edit" title="{{ __('general.edit') }}">
                                        <i class="fas fa-wrench"></i>
                                    </a>
                                @endcan

                                @can('delete', $post)
                                    <form action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="post" value="{{ $post->id }}">
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
            {{ $posts->links() }}
        </div>
    </div>
@endsection
