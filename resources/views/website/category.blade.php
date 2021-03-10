@extends('website.template.master')
@section('title')
   {{ $category->name }} - CungCodeNao
@endsection
@section('content') 
  <section class="call-to-action">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="main-content" style="background-image: url('{{ asset('storage/categories/' . $category->thumbnail) }}')" alt="{{ $category->name }}">
            <span>Danh sách bài biết thuộc thể loại {{ $category->name }}</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="blog-posts">
    <div class="container">
      <div class="row">
        <div class="col-md-9">
          <div class="all-blog-posts">
            <div class="row">
              @if (count($posts) <= 0)
                <h1>Hiện tại thể loại này chưa có bài biết nào.</h1>  
              @endif
              @foreach ($posts as $post)
              <div class="col-md-6">
                <div class="blog-post">
                  <a href="{{ url('post/' . $post->slug) }}">
                    <div class="blog-thumb">
                      <img src="{{ asset('storage/posts/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                    </div>
                  </a>
                  <div class="down-content">
                    <a href="{{ url('post/' . $post->slug) }}"><h4>{{ $post->title }}</h4></a>
                    <hr>
                    <ul class="post-info">
                      <li>Đăng bởi: {{ $post->user->name }}</li>
                      <li><i class="fa fa-history"></i> {{ $post->created_at->diffForHumans() }}</li>
                    </ul>
                    <hr>
                    <a href="{{ url('post/' . $post->slug) }}"><p>{{ $post->sub_title }}</p></a>
                    <hr>
                    <div class="row">
                      <div class="col-md-6"><i class="fa fa-reply"></i> {{ count($post->comments) }} bình luận</div>
                      <div class="col-md-6"><i class="fa fa-eye"></i> {{ $post->view_post }} lượt xem</div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>

            <div class="clearfix mt-4 float-right">
              {{ $posts->links() }}
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="sidebar">
            <div class="row">
              <div class="col-lg-12">
                <div class="sidebar-item search">
                  <form id="search_form" method="GET" action="{{ route('search') }}">
                    <input type="text" name="search" class="searchText" placeholder="nhập để tìm kiếm...">
                  </form>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="sidebar-item recent-posts">
                  <div class="sidebar-heading">
                    <h2>Bài viết gần đây</h2>
                  </div>
                  <div class="content">
                    <ul>
                      @foreach ($post_latest as $value)
                          <li>
                            <a href="{{ url('post/' . $value->slug) }}">
                              <h5>{{ $value->title }}</h5>
                              <span><i class="fa fa-history"></i> {{ $value->created_at->diffForHumans() }}</span>
                            </a>
                          </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="sidebar-item categories">
                  <div class="sidebar-heading">
                    <h2>Thể loại bài viết</h2>
                  </div>
                  <div class="content">
                    <ul>
                      @foreach ($categories as $value)
                        <li><a href="{{ url('category/' . $value->slug) }}">- {{ $value->name }}</a></li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection