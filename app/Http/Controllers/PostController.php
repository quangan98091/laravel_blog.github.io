<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')->where('post_type', 'post')->get();
        $categories = Category::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.post.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "thumbnail" => 'required|mimes:jpg,jpeg,png,gif',
            "title" => 'required|unique:posts',
            "details" => "required",
            "category_id" => "required"
        ],
            [
                'thumbnail.required' => 'Hình ảnh tiêu đề không được để trống.',
                'thumbnail.mimes' => 'Chỉ chấp nhận hình ảnh với đuôi .jpg /.jpeg / .png / .gif',
                'title.required' => 'Tiêu đề bài viết không được để trống.',
                'title.unique' => 'Tiêu đề này đã tồn tại.',
                'details.required' => 'Nội dung bài viết không được để trống',
                'category_id.required' => 'Hãy chọn ít nhất một thể loại cho bài viết.',
            ]
        );

        $fileNameWithExt = $request->thumbnail->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $fileExt = $request->thumbnail->getClientOriginalExtension();
        $thumbnail = $fileName . '_' . time() . '.' . $fileExt;
        
        $post = new  Post();
        $post->user_id = Auth::id();
        $post->thumbnail = $thumbnail;
        $post->title = $request->title;
        $post->slug = str_slug($request->title);
        $post->sub_title = $request->sub_title;
        $post->details = $request->details;
        $post->is_published = $request->is_published;
        $post->post_type = 'post';
        $save = $post->save();

        if ($save) {
            $request->thumbnail->storeAs('public/posts', $thumbnail);
        }

        $post->categories()->sync($request->category_id, false);

        Session::flash('message', 'Bạn đã tạo mới thành công một bài viết');
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.post.edit', compact('categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {   
        if($request->test_post == 0) {
            $this->validate($request, [
                "new_thumbnail" => 'required|mimes:jpg,jpeg,png,gif'
            ],
                [
                    'new_thumbnail.required' => 'Hình ảnh tiêu đề không được để trống.',
                    'new_thumbnail.mimes' => 'Chỉ chấp nhận hình ảnh với đuôi .jpg / .jpeg / .png / .gif'
                ]
            );

            $old_thumbnail = $request->old_thumbnail;

            $fileNameWithExt = $request->new_thumbnail->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileExt = $request->new_thumbnail->getClientOriginalExtension();
            $new_thumbnail = $fileName . '_' . time() . '.' . $fileExt;

            $post->thumbnail = $new_thumbnail;
            $save = $post->save();
            
            if ($save) {
                $request->new_thumbnail->storeAs('public/posts', $new_thumbnail);
                Storage::delete('/public/posts/' . $old_thumbnail);
            }


            Session::flash('message', 'Bài viết đã cập nhập thành công hình ảnh bài viết.');
            return redirect()->route('posts.index');
        } 
        if($request->test_post == 1) {

            $this->validate($request, [
                'title' => 'required|unique:posts,title,' . $post->id . ',id', // ignore this id
                'details' => 'required',
                "category_id" => "required"
            ],
                [
                    'title.required' => 'Tiêu đề bài viết không được để trống.',
                    'title.unique' => 'Tiêu đề này đã tồn tại.',
                    'details.required' => 'Nội dung bài viết không được để trống',
                    'category_id.required' => 'Hãy chọn ít nhất một thể loại cho bài viết.'
                ]
            );
          
            $post->user_id = Auth::id();
            $post->title = $request->title;
            $post->slug = str_slug($request->title);
            $post->sub_title = $request->sub_title;
            $post->details = $request->details;
            $post->is_published = $request->is_published;
            $save = $post->save();

            $post->categories()->sync($request->category_id);

            Session::flash('message', 'Bài viết đã cập nhập thành công nội dung bài viết.');
            return redirect()->route('posts.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // Delete image file
        Storage::delete('/public/posts/' . $post->thumbnail);

        $post->delete();

        Session::flash('delete-message', 'Bài viết đã xóa thành công.');
        return redirect()->route('posts.index');
    }

}