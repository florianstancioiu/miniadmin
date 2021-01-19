@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('page-title')
    Dashboard
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Dashboard v1</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">

            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $posts_total }}</h3>

                        <p>Total Posts</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $pages_total }}</h3>

                        <p>Total Pages</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $users_total }}</h3>

                        <p>Total Users</p>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- /.container-fluid -->
@endsection
