<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

//updates next version
// 1: refactoring
// 2: validate all data and prompt user with alert messages when needed use ->withInput method to do this
// 3: returning view() or redirect distinction. Only use views for get request and redirects for post request.
// 4: rename all the function to better reflect their function
// 5: replace variable whitespace with underscores.

class PostsController extends Controller
{

 
    // creates the pagination restults for the posts
    //1: change function name to a better name
    public function testData(){

        $postData = Post::orderBy('id', 'DESC')->paginate(8);
        return view('posts',compact('postData'));
    }

    // saves the edited post message of deletes the post message.
    //1: also include title change.
    public function saveDelete(Request $request){

        $saveOrDelete = $request->all();

        $id = $request->input('id');

        switch ($request->input('ButtonState')) {
            case 'Delete':
                Post::find($id)->delete();
                break;

            case 'Save':
                $post = Post::find($id);
                $post["post"] = $request->input('post_text');
                $post->save();
                break;
            
            default:
                # code...
                break;
        }
        $postData = Post::paginate(8);
        return view('posts',compact('postData'));    }

    // create a new post message
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

  
}
