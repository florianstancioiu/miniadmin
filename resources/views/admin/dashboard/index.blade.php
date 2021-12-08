@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $posts_total }}</h3>

                        <p>{{ __('dashboard.total_posts') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    @can('view posts')
                        <a href="{{ route('admin.posts.index') }}" class="small-box-footer">
                            <span>{{ __('dashboard.more_info')}}</span>
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    @else
                        <p class="small-box-footer">
                            <span>{{ __('dashboard.cant_view_more_info')}}</span>
                        </p>
                    @endcan
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $pages_total }}</h3>

                        <p>{{ __('dashboard.total_pages') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    @can('view pages')
                        <a href="{{ route('admin.pages.index') }}" class="small-box-footer">
                            <span>{{ __('dashboard.more_info') }}</span>
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    @else
                        <p class="small-box-footer">
                            <span>{{ __('dashboard.cant_view_more_info')}}</span>
                        </p>
                    @endcan
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $users_total }}</h3>

                        <p>{{ __('dashboard.total_users') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    @can('view users')
                        <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                            <span>{{ __('dashboard.more_info')}}</span>
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    @else
                        <p class="small-box-footer">
                            <span>{{ __('dashboard.cant_view_more_info')}}</span>
                        </p>
                    @endcan
                </div>
            </div>

            <div class="col-12">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('dashboard.avatar') }}</th>
                            <th scope="col">{{ __('dashboard.name') }}</th>
                            <th scope="col">{{ __('dashboard.email') }}</th>
                            <th scope="col">{{ __('dashboard.created_at') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latest_users as $user)
                            <tr>
                                <th scope="row">
                                    @if($user->image)
                                        <img src="{{ $user->image_url }}" class="pagination-img" alt="" data-toggle="tooltip" data-placement="top" data-html="true" title="<img class='tooltip-img' src='{{ $user->image_url }}'>">
                                    @else
                                        <img src="{{ url('img/no-image.png') }}" class="pagination-img" alt="" data-toggle="tooltip" data-placement="top" data-html="true" title="<img class='tooltip-img' src='{{ url('img/no-image.png') }}'>">
                                    @endif
                                </th>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->toFormattedDateString() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
