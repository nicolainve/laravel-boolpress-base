<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\InfoPost;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->simplePaginate(5);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $request->validate($this->ruleValidation());

        $data['slug'] = Str::slug($data['title'], '-');

        if(!empty($data['path_img'])) {
            $data['path_img'] = Storage::disk('public')->put('images', $data['path_img']);
        }

        $newPost = new Post();
        $newPost->fill($data);

        $saved = $newPost->save();

        $data['post_id'] = $newPost->id;
        $newInfo = new infoPost($data);
        $newInfo->fill($data);
        $newInfo->save();
        $infoSaved = $newInfo->save();

        if($saved && $infoSaved) {
            return redirect()->route('posts.index');
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->first();

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $request->validate($this->ruleValidation());

        $post = Post::find($id);

        $data['slug'] = Str::slug($data['title'], '-');

        if(!empty($data['path_img'])) {
            if (!empty($post->path_img)) {
                Storage::disk('public')->delete($post->path_img);
            }
            $data['path_img'] = Storage::disk('public')->put('images', $data['path_img']);
        }

        $updated = $post->update($data);

        $data['post_id'] = $post->id;
        $info = InfoPost::where('post_id', $post->id)->first();
        $infoUpdated = $info->update($data);

        if($updated && $infoUpdated) {
            return redirect()->route('posts.show', $post->slug);
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $tit = $post->title;
        $image = $post->path_img;
        $deleted = $post->delete();

        if($deleted) {
            if (!empty($post->$image)) {
                Storage::disk('public')->delete($post->$image);
            }
            return redirect()->route('posts.index')->with('post-delete', $tit);
        } else {
            return redirect()->route('home');
        }
    }

    private function ruleValidation() {
        return [
            'title' => 'required',
            'body' => 'required',
            'path_img' => 'image'
        ];
    }
}
