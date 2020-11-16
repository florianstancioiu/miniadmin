@extends('layouts.admin')

@section('title')
    Create User
@endsection

@section('page-title')
    Create User
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@endsection

@section('content')
    <div class="col-md-12">
    <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create User</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

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
                        <input type="text" name="first_name" class="form-control" id="form-first-name" placeholder="Enter first name">
                    </div>

                    <div class="form-group">
                        <label for="form-last-name">Last Name</label>
                        <input type="text" name="last_name" class="form-control" id="form-last-name" placeholder="Enter last name">
                    </div>

                    <div class="form-group">
                        <label for="form-email">Email</label>
                        <input type="text" name="email" class="form-control" id="form-email" placeholder="Enter email">
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
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
@endsection
