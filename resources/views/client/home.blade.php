@extends('layouts.client')

@section('header')
    <header class="masthead" style="background-image: url('img/home-bg.jpg')">
        <div class="overlay"></div>
        
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="site-heading">
                        <h1>Clean Blog</h1>
                        <span class="subheading">A Blog Theme by Start Bootstrap</span>
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
                <p class="post-meta">Posted by
                    <a href="#">{{ $post->user->full_name }}</a>
                    on {{ $post->created_at->format('d/m/Y') }}</p>
            </div>
            <hr>
        @endforeach

        {{ $posts->links() }}

        <!-- Pager
        <div class="clearfix">
            <a class="btn btn-primary float-right" href="#">Older Posts &rarr;</a>
        </div>
        -->
    </div>
@endsection
