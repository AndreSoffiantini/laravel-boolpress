@extends('layouts.admin')


@section('content')

<div class="posts d-flex py-4">
    <div class="cover_image">
        <img width="400" class="img-fluid" src="{{asset('storage/' . $post->cover_image)}}" alt="{{$post->title}}">
    </div>

    <div class="post-data px-4">
        <h1>{{$post->title}}</h1>
        <div class="metadata">

        </div>
        <div class="content">
            {{$post->content}}
        </div>
    </div>
</div>


@endsection