@extends('layouts.app')
@section('title')
    Bình luận - CungCodeNao
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
                    <div class="card-header">Danh sách bình luận</div>
                    
                    <div class="card-body">
                        <table id="comment" class="table table-bordered mb-0">
                            <thead>
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col" width="20%">Tên bài viết</th>
                                <th scope="col">Nội dung bình luận</th>
                                <th scope="col" width="15%">Thông tin</th>
                                <th scope="col" width="5%">Trạng thái</th>
                                <th scope="col" width="10%">Thao tác</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <td>{{ $comment->id }}</td>
                                    <td><a href="{{ url('post/' . $comment->post->slug) }}">{{ $comment->post->title }}</a></td>
                                    <td>{{ $comment->message}}</td>
                                    <td>
                                        Tên: {{ $comment->nickname }} <br>
                                        Email: {{ $comment->email }} -  {{ $comment->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        @foreach ($comment->replies as $reply)
                                            @if ($reply->nickname == 'admin')
                                                Đã trả lời 
                                                @break
                                            @endif
                                        @endforeach
                                    </td>
                                    <td style="text-align: center;">
                                        @if (count($comment->replies) <= 0)
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#see{{ $comment->id }}">Trả lời</button>
                                        <div class="modal fade" id="see{{ $comment->id }}" tabindex="-1" aria-labelledby="seeM{{ $comment->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="seeM{{ $comment->id }}">Tiêu đề bài bình luận: {{ $comment->post->title }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('replies.store') }}" method="post" style="border: 1px solid #efefef; padding: 12px 12px; border-radius: 15px; overflow: hidden;">
                                                            @csrf
                                                            <input type="text" name="comment_id" value="{{ $comment->id }}" hidden>
                                                            <input class="form-control" name="nickname" type="text" id="nickname" value="admin" readonly>
                                                            <hr>
                                                            <input class="form-control" name="email" type="text" id="email" value="admin@gmail.com" readonly>
                                                            <hr>
                                                            <textarea class="form-control" name="message" rows="5" id="message" required>@.{{$comment->nickname}} </textarea>
                                                            <hr>
                                                            <button type="submit" id="form-submit" class="btn btn-secondary float-right">Gửi</button>
                                                        </form>  
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <a href="{{ route('replies.show', $comment->id) }}" target="_blank" class="btn btn-sm btn-warning" style="margin-left:10px; margin-right:10px;">Tất cả trả lời</a>
                                        @endif
                                        <hr>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#drop{{$comment->id}}">Xóa</button>
                                        <div class="modal fade" id="drop{{$comment->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="dropL{{$comment->id}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="dropL{{$comment->id}}">Bạn có chắc muốn xóa bình luận này??</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                {!! Form::open(['route' => ['comments.destroy', $comment->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
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
            $('#comment').DataTable();
        } );
    </script>
@endsection
