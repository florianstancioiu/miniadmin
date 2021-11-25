@extends('layouts.admin')

@section('title')
    {{ __('roles.create_role') }}
@endsection

@section('content')
    <div class="col-md-10 col-lg-8 offset-lg-2">
        <div class="card card-primary">
            <form role="form" action="{{ route('admin.roles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="form-title">{{ __('roles.title') }}</label>
                        <input type="text" name="title" class="form-control" id="form-title" placeholder="{{ __('roles.enter_title') }}">
                    </div>
                    <div class="form-group">
                        <label for="form-slug">{{ __('roles.slug') }}</label>
                        <input type="text" name="slug" class="form-control" id="form-slug" placeholder="{{ __('roles.enter_slug') }}">
                    </div>

                    @foreach($permissions as $permission)
                        <div class="form-group">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="form-permission-{{$permission->slug}}">
                            <label for="form-permission-{{$permission->slug}}">{{ $permission->title }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-create">{{ __('general.create') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
