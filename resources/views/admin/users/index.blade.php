@extends('layouts.admin')

@section('title')
    {{ __('users.users') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            @can('create users')
                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary btn-add-new">
                    <i class="fas fa-plus"></i>
                    <span>{{ __('general.add_new') }}</span>
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
                        <th>{{ __('general.image') }}</th>
                        <th>{{ __('general.full_name') }}</th>
                        <th>{{ __('general.email') }}</th>
                        <th>{{ __('general.role') }}</th>
                        <th>{{ __('general.created_at') }}</th>
                        <th>{{ __('general.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                @if ($user->image)
                                    <img src="{{ $user->image_url }}" class="pagination-img" alt="">
                                @else
                                    <img src="{{ url('img/no-image.png') }}" class="pagination-img" alt="">
                                @endif
                            </td>
                            <td>{{ $user->getFullName() }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    {{ $role->name }}
                                @endforeach
                            </td>
                            <td>{{ $user->created_at->toFormattedDateString() }}</td>
                            <td class="actions-cell">
                                @can('update', $user)
                                    <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}" class="btn btn-primary btn-sm btn-edit" title="{{ __('general.edit') }}">
                                        <i class="fas fa-wrench"></i>
                                    </a>
                                @endcan

                                @can('delete', $user)
                                    <form action="{{ route('admin.users.destroy', ['user' => $user->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="user" value="{{ $user->id }}">
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
            {{ $users->links() }}
        </div>
    </div>
@endsection
