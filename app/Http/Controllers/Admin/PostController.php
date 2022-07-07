<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Mail\NewPostCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderByDesc('id')->get();
        //dd($posts);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$categories = Category::all();
        //$tags = Tag::all();
        //dd($categories);
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //ddd($request->all());

        $val_data = $request->validated();

        $slug = Str::slug($request->title, '-');

        //dd($slug);

        $val_data['slug'] = $slug;

        //$val_data['user_id'] = Auth::id();


        //ddd($request->hasFile('cover_image'));

        if($request->hasFile('cover_image')) {

            $request->validate([
                'cover_image' => 'nullable|image|max:500',
            ]);

            //ddd($request->all());

            $path = Storage::put('post_images', $request->cover_image);

            //ddd($path);

            $val_data['cover_image'] = $path;
        }

        //ddd($val_data);

        $new_post = Post::create($val_data);

        //Anteprima mail
        //return (new NewPostCreated($new_post))->render();

        Mail::to($request->user())->send(new NewPostCreated($new_post));

        return redirect()->route('admin.posts.index')->with('message', 'Post Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\PostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        //dd($request->all());

        $val_data = $request->validated();

        $slug = Str::slug($request->title, '-');

        $val_data['slug'] = $slug;

        //dd($val_data);

        if($request->hasFile('cover_image')) {

            $request->validate([
                'cover_image' => 'nullable|image|max:500',
            ]);

            Storage::delete($post->cover_image);

            //ddd($request->all());

            $path = Storage::put('post_images', $request->cover_image);

            //ddd($path);

            $val_data['cover_image'] = $path;
        }

        $post->update($val_data);

        return redirect()->route('admin.posts.index')->with('message', 'Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('message', "$post->title deleted successfully");
    }
}
