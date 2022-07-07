@extends('layouts.admin')


@section('content')

<h2 class="py-4">Edit {{$post->title}}}</h2>
@include('partials.errors')
<form action="{{route('admin.posts.update', $post->id)}}" method="post">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Learn php article" aria-describedby="titleHelper" value="{{old('title', $post->title)}}">
        <small id="titleHelper" class="text-muted">Type the post title, max: 150 carachters</small>
    </div>

    <div class="mb-4">
        <label for="cover_image">cover_image</label>
        <input type="file" name="cover_image" id="cover_image" class="form-control  @error('cover_image') is-invalid @enderror" placeholder="Learn php article" aria-describedby="cover_imageHelper">
        <small id="cover_imageHelper" class="text-muted">Type the post cover_image</small>
    </div>

    <div class="mb-4">
        <label for="content">Content</label>
        <textarea class="form-control  @error('content') is-invalid @enderror" name="content" id="content" rows="4">
        {{old('content', $post->content)}}
        </textarea>
    </div>

    <button type="submit" class="btn btn-primary">Edit Post</button>

</form>

@endsection