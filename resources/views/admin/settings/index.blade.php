@extends('layouts.admin')

@section('title')
    Settings
@endsection

@section('page-title')
    Settings
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item active">Settings</li>
    </ol>
@endsection

@section('content')
    <div class="col-md-12">
    <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Settings</h3>
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
                                <input type="text" name="setting[{{ $setting->key }}]" class="form-control" id="input-{{ $setting->key }}" value="{{ $setting->value }}" placeholder="{{ $setting->key }}">
                            </div>
                        @elseif($setting->type === 'textarea')
                             <div class="form-group">
                                <label for="input-{{ $setting->key }}">{{ $setting->title }}</label>
                                <textarea name="setting[{{ $setting->key }}]" id="input-{{ $setting->key }}" class="form-control" cols="30" rows="10" placeholder="{{ $setting->key }}">{{ $setting->value }}</textarea>
                            </div>
                        @elseif($setting->type === 'image')
                            <div class="form-group">
                                <label for="input-{{ $setting->key }}">{{ $setting->title }}</label>
                                @if ($setting->value != null)
                                    <img src="{{ url('storage/'. $setting->value) }}" alt="" class="form-image">
                                @endif
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="setting[{{ $setting->key }}]" class="custom-file-input" id="input-{{ $setting->key }}" accept="image/*">
                                        <label class="custom-file-label" for="input-{{ $setting->key }}">Choose image</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
