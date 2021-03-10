<?php

namespace App\Http\Controllers;

use App\Comment;
use App\CommentReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CommentReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['message' => 'required|max:100000']); 
        $reply = new CommentReply();
        $reply->comment_id = $request->comment_id;
        $reply->nickname = $request->nickname;
        $reply->email = $request->email;
        $reply->message = $request->message;
        $save = $reply->save();

        if($save) 
            Session::flash('success', 'Bạn đã trả lời một bình luận vào bài viết này.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $replies = CommentReply::where('comment_id', $id)->get();
        $comment_title = Comment::where('id', $id)->first();
        Session::flash('reply-title', $comment_title->message);
        return view('admin.comment.reply', compact('replies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $this->validate($request, ['message' => 'required|max:100000']); 
        $reply =  CommentReply::findOrFail($id);
        $reply->message = $request->message;
        $save = $reply->save();

        if($save) 
            Session::flash('success', 'Bạn đã cập nhập trả lời thành công.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reply = CommentReply::findOrFail($id);
        $reply->delete();

        Session::flash('delete-message', 'Bạn đã xóa thành công một bình luận');
        return redirect()->back();
    }
}
