@extends('layouts.app')
@section('title')
    Danh mục trang hiển thị - CungCodeNao
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
                        Danh sách trang hiển thị
                        <a href="{{ route('pages.create') }}" target="_blank" class="btn btn-sm btn-primary float-right">Thêm bài trang hiển thị</a>
                    </div>

                    <div class="card-body">
                        <table id="page" class="table table-bordered mb-0">
                            <thead>
                            <tr>
                                <th scope="col" width="60">#</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col" width="200">Đăng bởi</th>
                                <th scope="col" width="100">Trạng thái</th>
                                <th scope="col" width="200">Thao tác</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td>{{ $page->id }}</td>
                                    <td>{{ $page->title }}</td>
                                    <td>{{ $page->user->name }}</td>
                                    <td>{{ ($page->is_published == 1) ? "Hiển thị" : "Ẩn" }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#see{{ $page->id }}">Xem</button>
                                        <div class="modal fade" id="see{{ $page->id }}" tabindex="-1" aria-labelledby="seeM{{ $page->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="seeM{{ $page->id }}">{{ $page->title }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <ul>
                                                                    <li>Tóm tắt nội dung: {{ $page->sub_title }}</li>
                                                                    <li>Nội dung: {!! $page->details !!}</li>
                                                                </ul>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <img style="max-width: 200px;  max-height: 600px;" src="{{ asset('storage/pages/' . $page->thumbnail) }}" alt="{{ asset('storage/pages/' . $page->thumbnail) }}">
                                                            </div>
                                                        </div>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="{{ route('pages.edit', $page->id) }}" target="_blank" class="btn btn-sm btn-warning" style="margin-left:10px; margin-right:10px;">Sửa</a>
                                        
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#drop{{$page->id}}">Xóa</button>
                                        <div class="modal fade" id="drop{{$page->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="dropL{{$page->id}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="dropL{{$page->id}}">Bạn có chắc muốn xóa trang hiển thị này??</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                {!! Form::open(['route' => ['pages.destroy', $page->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
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
            $('#page').DataTable();
        } );
    </script>
@endsection