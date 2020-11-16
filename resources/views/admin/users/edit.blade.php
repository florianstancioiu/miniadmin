@extends('layouts.admin')

@section('title')
    Update User
@endsection

@section('page-title')
    Update User
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">Update</li>
    </ol>
@endsection

@section('content')
    <div class="col-md-12">
    <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update User</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.users.update', ['id'=> $user->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    
                    <input type="hidden" name="id" value="{{ $user->id }}"/>

                    <div class="form-group">
                        <label for="form-image">Image</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="form-image" accept="image/*">
                                <label class="custom-file-label" for="form-image">Choose image</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="form-first-name">First Name</label>
                        <input type="text" name="first_name" class="form-control" id="form-first-name" placeholder="Enter first name" value="{{ $user->first_name }}">
                    </div>

                    <div class="form-group">
                        <label for="form-last-name">Last Name</label>
                        <input type="text" name="last_name" class="form-control" id="form-last-name" placeholder="Enter last name" value="{{ $user->last_name }}">
                    </div>

                    <div class="form-group">
                        <label for="form-email">Email</label>
                        <input type="text" name="email" class="form-control" id="form-email" placeholder="Enter email" value="{{ $user->email }}">
                    </div>

                    <div class="form-group">
                        <label for="form-password">Password</label>
                        <input type="password" name="password" class="form-control" id="form-password" placeholder="Enter password">
                    </div>

                    <div class="form-group">
                        <label for="form-confirm-password">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="form-confirm-password" placeholder="Enter password confirmation">
                    </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
