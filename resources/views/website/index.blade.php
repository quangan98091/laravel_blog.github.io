@extends('website.template.master')
@section('title')
    Trang chủ - CungCodeNao    
@endsection

@section('content')
    <section class="blog-posts">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="all-blog-posts">
              <div class="row">
                @foreach ($posts as $post)
                <div class="col-lg-6">
                  <div class="blog-post">
                    <a href="{{ url('post/' . $post->slug) }}">
                      <div class="blog-thumb">
                        <img src="{{ asset('storage/posts/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                      </div>
                    </a>
                    <div class="down-content">
                      <a href="{{ url('post/' . $post->slug) }}"><h4>{{ $post->title }}</h4></a>
                      <div style="padding-bottom: 2px;">Đăng bởi: {{ $post->user->name }}</div>
                      <ul class="post-info">
                        <li><i class="fa fa-history"></i> {{ $post->created_at->diffForHumans() }}</li>
                        <li><i class="fa fa-comment"></i> {{ count($post->comments) }} bình luận</li>
                      </ul> 
                      <hr>
                      <a href="{{ url('post/' . $post->slug) }}"><p>{{ $post->sub_title }}</p></a>
                      <hr>
                      <div class="post-options">
                        <div class="row">
                          <div class="col-md-9">
                            <ul class="post-tags">
                              <li><i class="fa fa-tags"></i></li>
                              @if(count($post->categories) > 0 && $post)
                                @foreach($post->categories as $category)
                                  @if ($category->is_published == 1)
                                    <a href="{{ url('category/' . $category->slug) }}">{{ $category->name }}</a>,
                                  @else
                                  {{ $category->name }}
                                  @endif
                                @endforeach
                              @else 
                                <i>Tự do</i>
                              @endif
                            </ul>
                          </div>
                          <div class="col-md-3">
                            <i class="fa fa-eye"></i> {{ $post->view_post }}
                          </div>
                        </div>
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
          <div class="col-lg-4">
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
                  <div class="sidebar-item categories">
                    <div class="sidebar-heading">
                      <h2>Thể loại bài viết</h2>
                    </div>
                    <div class="content">
                      <ul>
                        @foreach ($categories as $category)
                          <li><a href="{{ url('category/' . $category->slug) }}">- {{ $category->name }}</a></li>
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