@extends('layouts.app')
@section('title')
    Thể loại - CungCodeNao
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
                        Danh sách thể loại
                        <a href="{{ route('categories.create') }}" target="_blank" class="btn btn-sm btn-primary float-right">Thêm thể loại mới</a>
                    </div>

                    <div class="card-body">
                        <table id="category" class="table table-bordered mb-0">
                            <thead>
                            <tr>
                                <th scope="col" width="60">#</th>
                                <th scope="col">Tên thể loại</th>
                                <th scope="col" width="200">Đăng bởi</th>
                                <th scope="col" width="200">Hình ảnh</th>
                                <th scope="col" width="100">Trạng thái</th>
                                <th scope="col" width="150">Thao tác</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->user->name }}</td>
                                    <td>
                                        <img style="max-width: 200px;  max-height: 200px;" src="{{ asset('storage/categories/' . $category->thumbnail) }}" alt="{{ asset('storage/categories/' . $category->thumbnail) }}">
                                    </td>
                                    <td>{{ ($category->is_published == 1) ? "Hiển thị" : "Ẩn" }}</td>
                                    <td>
                                        <a href="{{ route('categories.edit', $category->id) }}" target="_blank" class="btn btn-sm btn-warning" style="margin-left:10px; margin-right:10px;">Sửa</a>
                                        
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#drop{{$category->id}}">Xóa</button>
                                        <div class="modal fade" id="drop{{$category->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="dropL{{$category->id}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="dropL{{$category->id}}">Bạn có chắc muốn xóa thể loại này??</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
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
@endsection

@section('javascript')
    <script src="http://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready( function () {
            $('#category').DataTable();
        } );
    </script>
@endsection