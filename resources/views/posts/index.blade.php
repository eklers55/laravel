@extends('layouts.default')

@section('content')
        <div class="row justify-content-center">
                <div class="col-md-8">
                <h1 id="h1p">Posts</h1>
                <br>
                @if(count($posts)>0)
                @foreach($posts as $post)
                <div class="card mb-4">              
                     <img style="width:100%"class = "card-img-top" src="/storage/cover_images/{{$post->cover_image}}">
                     <div class="card-body">  
                        <h2><a href="/posts/{{$post->id}}">{{$post->title}}</a></h2>
                        <div class="card-footer text-muted">
                        Created on {{$post->created_at}} by {{$post->user->name}}
                        </div>
                    </div>
                </div>
                @endforeach
                </div>
                         
        </div>    
            
            {{$posts->links()}}
        @else <p> No posts found! </p>
        @endif
@endsection