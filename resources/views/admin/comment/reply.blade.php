@extends('layouts.app')
@section('title')
    Trả lời  - CungCodeNao
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
                <p style="font-size: 19px; padding: 12px 10px; border-radius: 12px; overflow: hidden; background-image: linear-gradient(to right, #43a0ab61, pink); box-shadow: 0 0 9px 0px #101010; margin-bottom: 20px;">
                    Nội dụng bình luận: {{ Session('reply-title') }}
                </p>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Danh sách bình luận</div>
                    
                    <div class="card-body">
                        <table id="reply" class="table table-bordered mb-0">
                            <thead>
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col">Trả lời bình luận</th>
                                <th scope="col" width="20%">Thông tin</th>
                                <th scope="col" width="10%">Thời gian</th>
                                <th scope="col" width="10%">Thao tác</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($replies as $reply)
                                <tr>
                                    <td>{{ $reply->id }}</td>
                                    <td style="max-width:400px;">{{ $reply->message}}</td>
                                    <td>
                                        Tên: {{ $reply->nickname }} <br>
                                        Email: {{ $reply->email }}
                                    </td>
                                    <td>{{ $reply->created_at->diffForHumans() }}</td>
                                    <td style="text-align: center;">
                                        @if ($reply->nickname == 'admin')
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#see{{ $reply->id }}">Thay đổi</button>
                                        <div class="modal fade" id="see{{ $reply->id }}" tabindex="-1" aria-labelledby="seeM{{ $reply->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="seeM{{ $reply->id }}">Thay đổi câu trả lời</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input class="form-control" name="nickname" type="text" id="nickname" value="admin" readonly>
                                                        <hr>
                                                        <input class="form-control" name="email" type="text" id="email" value="admin@gmail.com" readonly>
                                                        <hr>
                                                        {!! Form::open(['route' => ['replies.update', $reply->id], 'method' => 'put']) !!}
                                                        {!! Form::textarea('message', $reply->message, ['class' => 'form-control']) !!}
                                                        <hr>
                                                        {!! Form::submit('Cập nhập',['class' => 'btn btn-primary float-right']) !!}
                                                        {!! Form::close() !!}
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else 
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#see{{ $reply->id }}">Trả lới</button>
                                        <div class="modal fade" id="see{{ $reply->id }}" tabindex="-1" aria-labelledby="seeM{{ $reply->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="seeM{{ $reply->id }}">Nội dung trả lời</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! Form::open(['route' => ['replies.store', $reply->id], 'method' => 'post']) !!}
                                                        {!! Form::hidden('comment_id', $reply->comment_id) !!}
                                                        {!! Form::hidden('nickname', 'admin') !!}
                                                        {!! Form::hidden('email', 'admin@gmail.com') !!}
                                                        {!! Form::textarea('message', '@'.$reply->nickname, ['class' => 'form-control']) !!}<hr> 
                                                        {!! Form::submit('Gửi',['class' => 'btn btn-primary float-right']) !!}
                                                        {!! Form::close() !!}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @endif
                                        <hr>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#drop{{$reply->id}}">Xóa</button>
                                        <div class="modal fade" id="drop{{$reply->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="dropL{{$reply->id}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="dropL{{$reply->id}}">Bạn có chắc muốn xóa bình luận này??</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                {!! Form::open(['route' => ['replies.destroy', $reply->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
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
            $('#reply').DataTable();
        } );
    </script>
@endsection
