@extends('layouts.app')
@section('title')
    Bài viết - CungCodeNao
@endsection

@section('stylesheet')
    <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet">
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

                @if(Session::has('delete-message'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        {{ Session('delete-message') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Danh sách bài viết
                        <a href="{{ route('posts.create') }}" target="_blank" class="btn btn-sm btn-primary float-right">Thêm bài viết mới</a>
                    </div>

                    <div class="card-body">
                        <table id="post" class="table table-bordered mb-0">
                            <thead>
                            <tr>
                                <th scope="col" width="60">#</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col" width="200">Đăng bởi</th>
                                <th scope="col" width="100">Trạng thái</th>
                                <th scope="col" width="50">Lượt xem</th>
                                <th scope="col" width="200">Thao tác</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>{{ ($post->is_published == 1) ? "Hiển thị" : "Ẩn" }}</td>
                                    <td>{{ $post->view_post }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#see{{ $post->id }}">Xem</button>
                                        <div class="modal fade" id="see{{ $post->id }}" tabindex="-1" aria-labelledby="seeM{{ $post->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="seeM{{ $post->id }}">{{ $post->title }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <ul>
                                                                    <li>Tóm tắt nội dung: {{ $post->sub_title }}</li>
                                                                    <li>Thể loại:
                                                                        @foreach($post->categories as $category)
                                                                            {{ $category->name }} / 
                                                                        @endforeach
                                                                    </li>
                                                                    <li>Nội dung: {!! $post->details !!}</li>
                                                                </ul>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <img style="max-width: 200px;  max-height: 600px;" src="{{ asset('storage/posts/' . $post->thumbnail) }}" alt="{{ asset('storage/posts/' . $post->thumbnail) }}">
                                                            </div>
                                                        </div>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="{{ route('posts.edit', $post->id) }}" target="_blank" class="btn btn-sm btn-warning" style="margin-left:10px; margin-right:10px;">Sửa</a>
                                        
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#drop{{$post->id}}">Xóa</button>
                                        <div class="modal fade" id="drop{{$post->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="dropL{{$post->id}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="dropL{{$post->id}}">Bạn có chắc muốn xóa bài viết này??</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                {!! Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                                {!! Form::submit('Đồng ý', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('javascript')
    <script src="http://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready( function () {
            $('#post').DataTable();
        } );
    </script>
@endsection
