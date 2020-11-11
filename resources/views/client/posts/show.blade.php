@extends('layouts.client')

@section('header')
    <header class="masthead" style="background-image: url('{{ $post->image_url }}')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="post-heading">
                        <h1>{{ $post->title }}</h1>
                        <span class="meta">Posted by <a href="#">{{ $post->user->full_name }}</a> on {{ $post->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="col-lg-8 col-md-10 mx-auto">
        {{ $post->content }}
     </div>
@endsection
