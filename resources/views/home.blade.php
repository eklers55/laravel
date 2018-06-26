@extends('layouts.default')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    @if(auth()->user()->administrator)
                    <br>
                    <a href = "posts/create" class="btn btn-primary">Create New Post</a>
                    <br>

                    <h2>Your Posts</h3>
                    @if(count($posts)>0)
                        <table class="table table-striped">
                          
                            @foreach($posts as $post)
                            <tr>
                                    <td>{{$post->title}}</td>
                                    <td><a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a></th>
                                    <td>        {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                        {!!Form::close()!!}</td>
                            </tr>
                            @endforeach
                        </table>
                        @else
                                <h3>You have no posts!</h3>
                        @endif
                    @endif
                  
@endsection
