<?php

namespace App\Http\Controllers;

use App\Mail\VisitorContact;
use App\Post;
use App\Category;
use App\Comment;
use App\CommentReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class WebsiteController extends Controller
{
    public function index()
    {
        $comments = Comment::orderBy('id', 'DESC')->get();
        $categories = Category::orderBy('name', 'ASC')->where('is_published', '1')->get();
        $posts = Post::orderBy('id', 'DESC')->where('post_type', 'post')->where('is_published', '1')->paginate(10);
        return view('website.index', compact('posts', 'categories', 'comments'));
    }

    public function post($slug)
    {
        $post_latest = Post::latest()->take(5)->where('is_published', '1')->where('post_type', 'post')->get();
        $categories = Category::orderBy('name', 'ASC')->where('is_published', '1')->get();
        $post = Post::where('slug', $slug)->where('post_type', 'post')->where('is_published', '1')->first();
        $comments = Comment::orderBy('id', 'DESC')->get();
        $replies = CommentReply::orderBy('id', 'DESC')->get();
        if($post) {
            $postKey = 'post_'.$post->id;
            if(!Session::has($postKey)){
                $post->increment('view_post');
                Session::put($postKey, 1);
            }
            return view('website.post', compact('post', 'categories', 'post_latest', 'comments','replies'));
        } else {
            return \Response::view('website.errors.404', array(), 404);
        }
    }

    public function category($slug)
    {
        $comments = Comment::orderBy('id', 'DESC')->get();
        $post_latest = Post::latest()->take(5)->where('is_published', '1')->where('post_type', 'post')->get();
        $categories = Category::orderBy('name', 'ASC')->where('is_published', '1')->get();
        $category = Category::where('slug', $slug)->where('is_published', '1')->first();
        if($category) {
            $posts = $category->posts()->orderBy('posts.id', 'DESC')->where('is_published', '1')->paginate(16);
            return view('website.category', compact('category', 'posts', 'categories', 'post_latest','comments'));
        } else {
            return \Response::view('website.errors.404', array(), 404);
        }
    }

    public function page($slug)
    {
        $page = Post::where('slug', $slug)->where('post_type', 'page')->where('is_published', '1')->first();
        if ($page) {
            return view('website.page', compact('page'));
        } else {
            return \Response::view('website.errors.404', array(), 404);
        }
    }

    public function showContactForm()
    {
        return view('website.contact');
    }

    // public function submitContactForm(Request $request)
    // {
    //     $data = [
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'tel' => $request->tel,
    //         'message' => $request->message,
    //     ];
        

    //    Mail::to('cungcodenao684@gmail.com')->send(new VisitorContact($data));

    //    Session::flash('message', 'Góp ý của bạn đã gửi thành công. Chúng tôi sẽ trả lời góp ý của bạn nhanh nhất có thể.');
    //    return redirect()->route('contact.show');
    // }

    public function search(Request $request)
    {
        $this->validate($request, ['search' => 'required|max:255']);
        $search = $request->search;
        $posts = Post::where('is_published', '1')->where('post_type', 'post')->where('title', 'like', "%$search%")->paginate(10);
        $count_posts = Post::where('is_published', '1')->where('post_type', 'post')->where('title', 'like', "%$search%")->get();
        $categories = Category::orderBy('name', 'ASC')->where('is_published', '1')->get();
        return view('website.search', compact('posts', 'search', 'categories', 'count_posts'));
    }

    public function saveComment(Request $request)
    {
        $this->validate($request, ['message' => 'required|max:100000']); 
        $comment = new Comment();
        $comment->post_id = $request->post_id;
        $comment->nickname = $request->nickname;
        $comment->email = $request->email;
        $comment->message = $request->message;
        $save = $comment->save();

        if($save) 
            Session::flash('comment', 'Bạn đã thêm một bình luận vào bài viết này.');
        return redirect()->back();
    }
    
    public function saveCommentReply(Request $request)
    {
        $this->validate($request, ['message' => 'required|max:100000']); 
        $comment = new CommentReply();
        $comment->comment_id = $request->comment_id;
        $comment->nickname = $request->nickname;
        $comment->email = $request->email;
        $comment->message = $request->message;
        $save = $comment->save();

        if($save) 
            Session::flash('comment', 'Bạn đã thêm một bình luận vào bài viết này.');
        return redirect()->back();
    }
}
