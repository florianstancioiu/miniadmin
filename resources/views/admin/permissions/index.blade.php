@extends('layouts.admin')

@section('title')
    {{ __('permissions.permissions') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            @can('create-permissions')
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-sm btn-primary btn-add-new">
                    <i class="fas fa-plus"></i>
                    <span>{{ __('general.add_new') }}</span>
                </a>
            @endcan

            <form class="form-inline admin-search-form" method="GET" action="{{ route('admin.permissions.index') }}">
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
                        <th>{{ __('permissions.title') }}</th>
                        <th>{{ __('permissions.slug') }}</th>
                        <th>{{ __('general.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->title }}</td>
                            <td>{{ $permission->slug }}</td>
                            <td class="actions-cell">
                                @if($can_edit_permissions)
                                    <a href="{{ route('admin.permissions.edit', ['permission' => $permission->id]) }}" class="btn btn-primary btn-sm btn-edit">
                                        <i class="fas fa-wrench"></i>
                                        {{ __('general.edit') }}
                                    </a>
                                @endif

                                @if($can_destroy_permissions)
                                    <form action="{{ route('admin.permissions.destroy', ['permission' => $permission->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="permission" value="{{ $permission->id }}">
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
        <div class="card-footer clearfix">
            {{ $permissions->links() }}
        </div>
    </div>
@endsection
