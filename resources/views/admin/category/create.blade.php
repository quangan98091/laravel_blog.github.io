<!Doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Thêm thể loại - CungCodeNao</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <br><br>
    <div class="container" style="border-radius: 9px; box-shadow: 0px 0px 20px 0px; overflow: hidden; padding: 12px;">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" style="font-size: 19px; font-family: cursive;">Thêm một thể loại mới.</div>

                    <div class="card-body">
                        {!! Form::open(['route' => 'categories.store', 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-group @if($errors->has('thumbnail')) has-error @endif">
                            {!! Form::label('Hình ảnh',null, ['style' => 'display: block;']) !!} 
                            {!! Form::file('thumbnail') !!}
                            @if ($errors->has('thumbnail'))
                                <span class="help-block alert alert-danger">{!! $errors->first('thumbnail') !!}</span>@endif
                        </div>

                        <div class="form-group @if($errors->has('name')) has-error @endif">
                            {!! Form::label('Tên thể loại') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            @if ($errors->has('name'))
                                <br><span class="help-block alert alert-danger">{!! $errors->first('name') !!}</span>@endif
                        </div>
                        
                        <div class="form-group">
                            {!! Form::label('Trạng thái') !!}
                            {!! Form::select('is_published', [1 => 'Hiển thị', 0 => 'Ẩn'], null, ['class' => 'form-control']) !!}
                        </div>

                        {!! Form::submit('Thêm mới',['class' => 'btn btn-primary btn-md float-right']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>