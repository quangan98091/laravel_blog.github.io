<!Doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sửa thể loại - CungCodeNao</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <br><br>
    <div class="container" style="border-radius: 9px; box-shadow: 0px 0px 20px 0px; overflow: hidden; padding: 12px;">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" style="font-size: 19px; font-family: cursive;">Sửa thể loại số #{{ $category->id }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::open(['route' => ['categories.update', $category->id], 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
                                <div class="form-group @if($errors->has('new_thumbnail')) has-error @endif">
                                    {!! Form::label('Hình tiêu đề',null, ['style' => 'display: block;']) !!} 
                                    {!! Form::file('new_thumbnail') !!}
                                    {!! Form::hidden('old_thumbnail', $category->thumbnail) !!}
                                    {!! Form::hidden('test_category', 0) !!}
                                    @if ($errors->has('new_thumbnail'))
                                        <br><br><span class="help-block alert alert-danger">{!! $errors->first('new_thumbnail') !!}</span>@endif
                                </div>
                                {!! Form::submit('Cập nhập hình ảnh',['class' => 'btn btn-primary btn-md']) !!}
                                {!! Form::close() !!}
                            </div>
                            <div class="col-md-6">
                                <img style="max-width: 200px;  max-height: 600px;" src="{{ asset('storage/categories/' . $category->thumbnail) }}" alt="{{ asset('storage/categories/' . $category->thumbnail) }}">
                            </div>
                        </div>
                        <br><hr>
                        {!! Form::open(['route' => ['categories.update', $category->id], 'method' => 'put']) !!}
                        {!! Form::hidden('test_category', 1) !!}
                        <div class="form-group @if($errors->has('name')) has-error @endif">
                            {!! Form::label('Tên thể loại') !!}
                            {!! Form::text('name', $category->name, ['class' => 'form-control']) !!}
                            @if ($errors->has('name'))
                                <br><span class="help-block alert alert-danger">{!! $errors->first('name') !!}</span>@endif
                        </div>

                        <div class="form-group">
                            {!! Form::label('Trạng thái') !!}
                            {!! Form::select('is_published', [1 => 'Hiển thị', 0 => 'Ẩn'], null, ['class' => 'form-control']) !!}
                        </div>

                        {!! Form::submit('Cập nhập nội dung',['class' => 'btn btn-primary btn-md float-right']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>