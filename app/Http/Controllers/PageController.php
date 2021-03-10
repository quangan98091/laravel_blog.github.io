<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Post::orderBy('id', 'DESC')->where('post_type', 'page')->get();
        return view('admin.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.page.create');
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
            "details" => "required"
        ],
            [
                'thumbnail.required' => 'Hình ảnh tiêu đề không được để trống.',
                'thumbnail.mimes' => 'Chỉ chấp nhận hình ảnh với đuôi .jpg /.jpeg / .png / .gif',
                'title.required' => 'Tiêu đề bài viết không được để trống.',
                'title.unique' => 'Tiêu đề này đã tồn tại.',
                'details.required' => 'Nội dung bài viết không được để trống'
            ]
        );
        $fileNameWithExt = $request->thumbnail->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $fileExt = $request->thumbnail->getClientOriginalExtension();
        $thumbnail = $fileName . '_' . time() . '.' . $fileExt;

        $page = new  Post();
        $page->user_id = Auth::id();
        $page->thumbnail = $thumbnail;
        $page->title = $request->title;
        $page->slug = str_slug($request->title);
        $page->sub_title = $request->sub_title;
        $page->details = $request->details;
        $page->is_published = $request->is_published;
        $page->view_post = 0;
        $page->post_type = 'page';
        $save = $page->save();

        if ($save) {
            $request->thumbnail->storeAs('public/pages', $thumbnail);
        }

        Session::flash('message', 'Bạn đã tạo mới thành công một trang mục lục.');
        return redirect()->route('pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Post::findOrFail($id);
        return view('admin/page/edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->test_page == 0) {
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

            $page = Post::findOrFail($id);         
            $page->thumbnail = $new_thumbnail;
            $save = $page->save();
            
            if ($save) {
                $request->new_thumbnail->storeAs('public/pages', $new_thumbnail);
                Storage::delete('/public/pages/' . $old_thumbnail);
            }


            Session::flash('message', 'Trang thông tin đã cập nhập thành công hình ảnh.');
            return redirect()->route('pages.index');
        } 
        if($request->test_page == 1) {
            $this->validate($request, [
                'title' => 'required|unique:posts,title,' . $id . ',id', // ignore this id
                'details' => 'required'
            ],
                [
                    'title.required' => 'Tiêu đề bài viết không được để trống.',
                    'title.unique' => 'Tiêu đề này đã tồn tại.',
                    'details.required' => 'Nội dung bài viết không được để trống'
                ]
            );

            $page = Post::findOrFail($id);
            $page->user_id = Auth::id();
            $page->title = $request->title;
            $page->slug = str_slug($request->title);
            $page->sub_title = $request->sub_title;
            $page->details = $request->details;
            $page->is_published = $request->is_published;
            $page->save();

            Session::flash('message', 'Trang thông tin đã cập nhập thành công nội dung.');
            return redirect()->route('pages.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Post::findOrFail($id);
        $page->delete();

        Session::flash('delete-message', 'Bạn đã xóa thành công một trang');
        return redirect()->route('pages.index');
    }
}