@extends('layouts.default')

@section('content')
@if(count($streams)>0)
    <table class="table table-bordered">
                              
    @foreach($streams as $stream)
    <tr>
    <td>{{$stream->stream_name}}</td>
    <td>{{$stream->sport}}</td>
    <td>{{$stream->link}}</td>
    </tr>
    @endforeach
    </table>
    @else
    <h3>There are no streams!</h3>
    @endif
@endsection