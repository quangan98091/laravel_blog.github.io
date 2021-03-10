<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        return view('admin.showProfile', compact('user'));
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
        if($request->test_pass == 1) {
            $this->validate($request, [
                    'old_password' => 'required',
                    'password' => 'required|min:8|confirmed'
                ],
                [
                    'old_password.required' => 'Vui lòng điền đầy đủ thông tin.',
                    'password.required' => 'Vui lòng điền đầy đủ thông tin.',
                    'password.min' => 'Mật khẩu mới ít nhất phải có 8 ký tự.',
                    'password.confirmed' => 'Xác nhận mật khẩu mới không khớp.'
                ]
            );
    
            $oldPass = Auth::user()->password; // hashed
            if (Hash::check($request->old_password, $oldPass)) {

                if (!Hash::check($request->password, $oldPass)) {
                    $user = User::find(Auth::id());
                    $user->password = Hash::make($request->password);
                    $user->save();
    
                    Session::flash('message', 'Bạn đã thay đổi thành công mật khẩu.');
                    return redirect()->route('user.index');
                } else {
                    Session::flash('error-message', 'Mật khẩu mới không được giống với mật khẩu cũ.');
                    return redirect()->route('user.index');
                }
            } else {

                Session::flash('error-message', 'Bạn đã nhập sai mật khẩu cũ.');
                return redirect()->route('user.index');
            }
        } 
        if($request->test_profile == 1) {
            $this->validate($request, [
                    'name' => 'required',
                    'email' => 'required'
                ],
                [
                    'name.required' => 'Vui lòng điền đầy đủ thông tin.',
                    'email.required' => 'Vui lòng điền đầy đủ thông tin.'
                ]
            );
    
            $user = User::find(Auth::id());
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            Session::flash('message', 'Bạn đã thay đổi thành công thông tin đăng nhập.');
            return redirect()->route('user.index');
        } 
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
