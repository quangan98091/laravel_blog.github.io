<!Doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Thêm bài viết - CungCodeNao</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <br><br>
    <div class="container" style="border-radius: 9px; box-shadow: 0px 0px 20px 0px; overflow: hidden; padding: 12px;">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" style="font-size: 19px; font-family: cursive;">Thêm một bài viết mới.</div>

                    <div class="card-body">
                        {!! Form::open(['route' => 'posts.store', 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-group @if($errors->has('thumbnail')) has-error @endif">
                            {!! Form::label('Hình tiêu đề',null, ['style' => 'display: block;']) !!} 
                            {!! Form::file('thumbnail') !!}
                            @if ($errors->has('thumbnail'))
                                <span class="help-block alert alert-danger">{!! $errors->first('thumbnail') !!}</span>@endif
                        </div>

                        <div class="form-group @if($errors->has('title')) has-error @endif">
                            {!! Form::label('Tiêu đề chính') !!}
                            {!! Form::text('title', null, ['class' => 'form-control']) !!}
                            @if ($errors->has('title'))
                                <br><span class="help-block alert alert-danger">{!! $errors->first('title') !!}</span>@endif
                        </div>

                        <div class="form-group @if($errors->has('sub_title')) has-error @endif">
                            {!! Form::label('Tiêu đề phụ') !!}
                            {!! Form::text('sub_title', null, ['class' => 'form-control']) !!}
                            @if ($errors->has('sub_title'))
                                <br><span class="help-block alert alert-danger">{!! $errors->first('sub_title') !!}</span>@endif
                        </div>

                        <div class="form-group @if($errors->has('details')) has-error @endif">
                            {!! Form::label('Nội dung') !!}
                            {!! Form::textarea('details', null, ['class' => 'form-control']) !!}
                            @if ($errors->has('details'))
                                <br><span class="help-block alert alert-danger">{!! $errors->first('details') !!}</span>@endif
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 form-group @if($errors->has('category_id')) has-error @endif">
                                {!! Form::label('Thể loại') !!}
                                {!! Form::select('category_id[]', $categories, null, ['class' => 'form-control', 'id' => 'category_id', 'multiple' => 'multiple']) !!}
                                @if ($errors->has('category_id'))
                                    <br><br><span class="help-block alert alert-danger">{!! $errors->first('category_id') !!}</span>
                                @endif
                            </div>
    
                            <div class="form-group col-md-6">
                                {!! Form::label('Trạng thái') !!}
                                {!! Form::select('is_published', [1 => 'Hiển thị', 0 => 'Ẩn'], null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        {!! Form::submit('Thêm mới',['class' => 'btn btn-primary btn-md float-right']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            CKEDITOR.replace('details');
            $('#category_id').select2({ placeholder: "Chọn thể loại" });
        });
    </script>
</body>
</html>