@extends('layouts.admin')

@section('title')
    {{ __('users.users') }}
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('general.admin') }}</a></li>
        <li class="breadcrumb-item active">{{ __('users.users') }}</li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            @can('create-users')
                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i>
                    <span>{{ __('users.add_new_user') }}</span>
                </a>
            @endcan

            <form class="form-inline admin-search-form" method="GET" action="{{ route('admin.users.index') }}">
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
                        <th style="width: 10px">#</th>
                        <th>{{ __('users.image') }}</th>
                        <th>{{ __('users.full_name') }}</th>
                        <th>{{ __('users.email') }}</th>
                        <th>{{ __('general.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                @if ($user->image)
                                    <img src="{{ $user->image_url }}" class="pagination-img" alt="">
                                @endif
                            </td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="actions-cell">
                                @if($can_edit_users)
                                    <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}" class="btn btn-primary btn-sm btn-edit">
                                        <i class="fas fa-wrench"></i>
                                        {{ __('general.edit') }}
                                    </a>
                                @endif

                                @if($can_destroy_users)
                                    <form action="{{ route('admin.users.destroy', ['user' => $user->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm btn-delete" type="submit">
                                            <i class="fas fa-trash"></i>
                                            {{ __('general.delete') }}
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

        <div class="card-footer clearfix">
            {{ $users->links() }}
        </div>
    </div>
    <!-- /.card -->
@endsection
