@extends('layouts.admin')

@section('title')
    {{ __('roles.roles') }}
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('general.admin') }}</a></li>
        <li class="breadcrumb-item active">{{ __('roles.roles') }}</li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i>
                <span>{{ __('roles.add_new_role') }}</span>
            </a>

            <form class="form-inline admin-search-form" method="GET" action="{{ route('admin.roles.index') }}">
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
                        <th style="width: 10px">#</th>
                        <th>{{ __('roles.title') }}</th>
                        <th>{{ __('roles.slug') }}</th>
                        <th>{{ __('general.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->title }}</td>
                            <td>{{ $role->slug }}</td>
                            <td class="actions-cell">
                                <a href="{{ route('admin.roles.edit', ['role' => $role->id]) }}" class="btn btn-primary btn-sm btn-edit">
                                    <i class="fas fa-wrench"></i>
                                    {{ __('general.edit') }}
                                </a>

                                <form action="{{ route('admin.roles.destroy', ['role' => $role->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm btn-delete" type="submit">
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
            {{ $roles->links() }}
        </div>
    </div>
    <!-- /.card -->
@endsection
