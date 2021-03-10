<?php

namespace App\Http\Controllers;

use App\Category;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "thumbnail" => 'required|mimes:jpg,jpeg,png,gif',
            "name" => 'required|unique:categories'
        ],
            [
                'thumbnail.required' => 'Hình ảnh thể loại không được để trống.',
                'thumbnail.mimes' => 'Chỉ chấp nhận hình ảnh với đuôi .jpg /.jpeg / .png / .gif',
                'name.required' => 'Tên thể loại không được để trống.',
                'name.unique' => 'Tên thể loại đã tồn tại.'
            ]
        );
        $fileNameWithExt = $request->thumbnail->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $fileExt = $request->thumbnail->getClientOriginalExtension();
        $thumbnail = $fileName . '_' . time() . '.' . $fileExt;

        $category = new Category();
        $category->thumbnail = $thumbnail;
        $category->user_id = Auth::id();
        $category->name = $request->name;
        $category->slug = str_slug($request->name);
        $category->is_published = $request->is_published;
        $save = $category->save();

        if ($save) {
            $request->thumbnail->storeAs('public/categories', $thumbnail);
        }

        Session::flash('message', 'Bạn đã tạo mới thành công một thể loại.');
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if($request->test_category == 0) {
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

            $category->thumbnail = $new_thumbnail;
            $save = $category->save();
            
            if ($save) {
                $request->new_thumbnail->storeAs('public/categories', $new_thumbnail);
                Storage::delete('/public/categories/' . $old_thumbnail);
            }


            Session::flash('message', 'Bài viết đã cập nhập thành công hình ảnh thể loại.');
            return redirect()->route('categories.index');
        } 
        if($request->test_category == 1) {

            $this->validate($request, [
                'name' => 'required|unique:categories,name,' . $category->id,
            ],
                [
                    'name.required' => 'Tiêu đề bài viết không được để trống.',
                    'name.unique' => 'Tiêu đề này đã tồn tại.'
                ]
            );
            
            $category->user_id = Auth::id();
            $category->name = $request->name;
            $category->slug = str_slug($request->name);
            $category->is_published = $request->is_published;
            $category->save();

            Session::flash('message', 'Bài viết đã cập nhập thành công nội dung thể loại.');
            return redirect()->route('categories.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Storage::delete('/public/categories/' . $category->thumbnail);

        $category->delete();

        Session::flash('delete-message', 'Thể loại đã xóa thành công.');
        return redirect()->route('categories.index');
    }
}
