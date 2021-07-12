<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function testData(){

        $postData = Post::orderBy('id', 'DESC')->paginate(8);
        return view('posts',compact('postData'));
    }

    public function saveDelete(Request $request){

        error_log("waarom doe tie itsids");
        $saveOrDelete = $request->all();
        error_log($request->id);

        $id = $request->input('id');

        switch ($request->input('ButtonState')) {
            case 'Delete':
                Post::find($id)->delete();
                break;

            case 'Save':
                $post = Post::find($id);
                $post["post"] = $request->input('post_text');
                $post->save();

                // Post::find($id) ->post = "new";
                break;
            
            default:
                # code...
                break;
        }
        $postData = Post::paginate(8);
        return view('posts',compact('postData'));    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $postText = $request->input('DiaryTextInput');
        $postTitle = $request->input('DiaryTitleInput');

        $post = new Post;
        $post->post = $postText;
        $post->title = $postTitle;

        $post->save();
        return redirect('/');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
