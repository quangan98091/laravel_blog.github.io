@extends('layouts.app')
@section('title')
    Admin - CungCodeNao
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">Bài viết mới nhất
                    <a href="{{ route('posts.index') }}" class="btn btn-sm btn-primary float-right">Xem thêm</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <td scope="col" with="60">#</td>
                                <td scope="col" with="60">Tiêu đề bài viết</td>
                                <td scope="col" with="200">Đăng bởi</td>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <th>{{ $post->id }}</th>
                                    <th>{{ $post->title }}</th>
                                    <th>{{ $post->user->name }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">Thể loại mới nhất
                    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-primary float-right">Xem thêm</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <td scope="col" with="60">#</td>
                                <td scope="col" with="60">Tên thể loại</td>
                                <td scope="col" with="200">Đăng bởi</td>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <th>{{ $category->id }}</th>
                                    <th>{{ $category->name }}</th>
                                    <th>{{ $category->user->name }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">Trang thông tin mới
                    <a href="{{ route('pages.index') }}" class="btn btn-sm btn-primary float-right">Xem thêm</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <td scope="col" with="60">#</td>
                                <td scope="col" with="60">Tên trang</td>
                                <td scope="col" with="200">Đăng bởi</td>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($pages as $page)
                                <tr>
                                    <th>{{ $page->id }}</th>
                                    <th>{{ $page->title }}</th>
                                    <th>{{ $page->user->name }}</th>
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

