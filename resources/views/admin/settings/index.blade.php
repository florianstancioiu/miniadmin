@extends('layouts.admin')

@section('title')
    {{ __('general.settings') }}
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('general.admin') }}</a></li>
        <li class="breadcrumb-item active">{{ __('general.settings') }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-md-12">
    <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('general.settings') }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.settings.index') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @foreach($settings as $setting)
                        @if($setting->type === 'text')
                            <div class="form-group">
                                <label for="input-{{ $setting->key }}">{{ $setting->title }}</label>
                                <input type="text" name="settings[{{ $setting->key }}]" class="form-control" id="input-{{ $setting->key }}" value="{{ $setting->value }}" placeholder="{{ $setting->title }}">
                            </div>
                        @elseif($setting->type === 'textarea')
                             <div class="form-group">
                                <label for="input-{{ $setting->key }}">{{ $setting->title }}</label>
                                <textarea name="settings[{{ $setting->key }}]" id="input-{{ $setting->key }}" class="form-control" cols="30" rows="5" placeholder="{{ $setting->title }}">{{ $setting->value }}</textarea>
                            </div>
                        @elseif($setting->type === 'image')
                            <div class="form-group">
                                <label for="input-{{ $setting->key }}">{{ $setting->title }}</label>
                                @if ($setting->value)
                                    <img src="{{ Storage::url($setting->value) }}" alt="" class="form-image">
                                @endif
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="settings[{{ $setting->key }}]" class="custom-file-input" id="input-{{ $setting->key }}" accept="image/*">
                                        <label class="custom-file-label" for="input-{{ $setting->key }}">Choose image</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <!-- /.card-body -->

                @can('store-settings')
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-save">{{ __('general.save') }}</button>
                    </div>
                @endcan
            </form>
        </div>
    </div>
@endsection
