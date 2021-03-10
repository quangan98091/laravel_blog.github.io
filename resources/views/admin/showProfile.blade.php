@extends('layouts.app')
@section('title')
    Thông tin tài khoản - CungCodeNao
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            @if(Session::has('message'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{ Session('message') }}
                </div>
            @endif

            @if(Session::has('error-message'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{ Session('error-message') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Thay đổi thông tin</div>

                <div class="card-body">
                    {!! Form::open(['route' => ['user.update', $user->id], 'method' => 'put']) !!}
                        {!! Form::hidden('test_profile', 1) !!}
                        <div class="form-group @if($errors->has('name')) has-error @endif">
                            {!! Form::label('Tên người dùng') !!}
                            {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                            @if ($errors->has('name'))
                                <br><span class="help-block alert alert-danger">{!! $errors->first('name') !!}</span>@endif
                        </div>

                        <div class="form-group @if($errors->has('email')) has-error @endif">
                            {!! Form::label('Tài khoản đăng nhập(email)') !!}
                            {!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
                            @if ($errors->has('email'))
                                <br><span class="help-block alert alert-danger">{!! $errors->first('email') !!}</span>@endif
                        </div>
                    {!! Form::submit('Cập nhập thông tin',['class' => 'btn btn-primary btn-md float-right']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Thay đổi mật khẩu</div>

                <div class="card-body">
                    {!! Form::open(['route' => ['user.update', $user->id], 'method' => 'put']) !!}
                        {!! Form::hidden('test_pass', 1) !!}
                        <div class="form-group @if($errors->has('old_password')) has-error @endif">
                            {!! Form::label('Nhập mật khẩu cũ') !!}
                            {!! Form::password('old_password', ['class' => 'form-control']) !!}
                            @if ($errors->has('old_password'))
                                <br><span class="help-block alert alert-danger">{!! $errors->first('old_password') !!}</span>@endif
                        </div>

                        <div class="form-group @if($errors->has('password')) has-error @endif">
                            {!! Form::label('Nhập mật khẩu mới') !!}
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                            @if ($errors->has('password'))
                                <br><span class="help-block alert alert-danger">{!! $errors->first('password') !!}</span>@endif
                        </div>

                        <div class="form-group @if($errors->has('password_confirmation')) has-error @endif">
                            {!! Form::label('Nhập lại mật khẩu mới') !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                            @if ($errors->has('password_confirmation'))
                                <br><span class="help-block alert alert-danger">{!! $errors->first('password_confirmation') !!}</span>@endif
                        </div>
                    {!! Form::submit('Cập nhập mật khẩu',['class' => 'btn btn-secondary btn-md float-right']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


