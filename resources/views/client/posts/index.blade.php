@extends('layouts.client')

@section('title')
    Posts
@endsection

@section('header')
    <header class="masthead" style="background-image: url({{ asset('storage/' . setting('site-home-bg')) }})">
        <div class="overlay"></div>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="site-heading">
                        <h1>Posts</h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="col-lg-8 col-md-10 mx-auto">

        @foreach($posts as $post)
            <div class="post-preview">
                <a href="{{ route('client.posts.show', ['slug'=>$post->slug]) }}">
                    <h2 class="post-title">{{ $post->title }}</h2>
                </a>
                <p class="post-meta">Posted by {{ $post->user->getFullName() }} on {{ $post->created_at->format('d/m/Y') }}</p>
            </div>
            <hr>
        @endforeach

        {{ $posts->links() }}
    </div>
@endsection
