@extends('website.template.master')
@section('title')
{{ $post->title}} - CungCodeNao
@endsection
@section('content')
<section class="blog-posts grid-system">
  <div class="container">
    <div class="row">
      <div class="col">
        @if(Session::has('comment'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
          {{ Session('comment') }}
        </div>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="all-blog-posts">
          <div class="row">
            <div class="col-lg-12">
              <div class="blog-post">
                <div class="blog-thumb">
                  <img src="{{ asset('storage/posts/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                </div>
                <div class="down-content">
                  <h4>{{ $post->title }}</h4>
                  <ul class="post-info">
                    <li>Đăng bởi: {{ $post->user->name }}</li>
                    <li>Vào ngày: {{ date('M d Y', strtotime($post->created_at)) }}</li>
                    <li><i class="fa fa-eye"></i> {{ $post->view_post }} lượt xem</li>
                  </ul>
                  <hr>
                  <p>{{ $post->sub_title }}</p><hr>
                  <div class="row">
                    <div class="col-lg-12" >
                      {!! $post->details !!}
                    </div>
                  </div>
                  <hr>
                  <div class="post-options">
                    <div class="row">
                      <div class="col-lg-12">
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
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="sidebar-item comments">
                <div class="sidebar-heading">
                  <h2>
                    @if (count($post->comments) > 0)
                    {{ count($post->comments) }} bình luận
                    @endif
                  </h2>
                </div>
                <div class="content">
                  @if (count($post->comments) <= 0)
                  <h3>Hiện tại bài viết này không có bình luận nào.</h3>
                  @endif
                  <ul>
                    @foreach ($post->comments as $comment)        
                    <li>
                      <div class="author-thumb">
                        <img src="{{ asset('website/assets/images/user.png') }}" alt="user">
                      </div>
                      <div class="right-content">
                        <h4>{{ $comment->nickname }}<span>{{ $comment->created_at->diffForHumans() }}</span></h4>
                        <p>{{ $comment->message }}</p>
                        <button style="margin-top: 10px; margin-left: 10px;" class="btn btn-secondary" onclick="showReplyForm('{{$comment->id}}','{{$comment->nickname}}')">
                          <i class="fa fa-reply"></i> Trả lời
                        </button>
                        @if(count($comment->replies) > 0)
                        <button style="margin-top: 10px; margin-left: 10px;" class="btn btn-primary" type="button" data-toggle="collapse" data-target="#comment{{ $comment->id}}" aria-expanded="false" aria-controls="comment{{ $comment->id}}">
                          <i class="fa fa-angle-down"></i> Xem thêm ({{ count($comment->replies )}})
                        </button>
                        @endif
                      </div>
                    </li>

                    @if(count($comment->replies) > 0)
                    <li class="replied">
                      <div class="collapse" id="comment{{ $comment->id}}">
                        @foreach($comment->replies as $reply)
                        <div class="reply-comment" style="border: 1px solid #9e9e9e; padding: 10px 10px; margin-top: 10px; border-radius: 12px; overflow: hidden;">
                          <div class="author-thumb">
                            <img src="{{ asset('website/assets/images/user.png') }}" alt="user">
                          </div>
                          <div class="right-content">  
                            <h4>{{ $reply->nickname }}<span>{{ $reply->created_at->diffForHumans() }}</span></h4>
                            <p>{{ $reply->message }}</p>
                            <button style="margin: 11px 10px;" class="btn btn-light" onclick="showReplyForm('{{$comment->id}}','{{$reply->nickname}}')">
                              <i class="fa fa-reply"></i> Trả lời
                            </button>
                          </div>
                        </div>
                        @endforeach
                      </div>                      
                    </li>
                    @endif

                    <div id="reply-form-{{$comment->id}}" style="display: none;">
                      <form action="{{ route('saveCommentReply') }}" method="post" style="border: 1px solid #efefef; padding: 12px 12px; border-radius: 15px; overflow: hidden;">
                        @csrf
                        <input type="text" name="comment_id" value="{{ $comment->id }}" hidden>
                        <input class="form-control" name="nickname" type="text" id="nickname" placeholder="Tên hiển thị" required>
                        <hr>
                        <input class="form-control" name="email" type="text" id="email" placeholder="Địa chỉ email" required>
                        <hr>
                        <textarea id="reply-form-{{$comment->id}}-text" class="form-control" name="message" rows="5" id="message" placeholder="Mời bạn để lại bình luận..." required></textarea>
                        <hr>
                        <button type="submit" id="form-submit" class="btn btn-secondary float-right">Gửi</button>
                      </form>                      
                    </div>
                    <hr>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="sidebar-item submit-comment">
                <div class="sidebar-heading">
                  <h2>Bình luận</h2>
                </div>
                <div class="content">
                  <form action="{{ route('saveComment') }}" method="post">
                    @csrf
                    <input type="text" name="post_id" value="{{ $post->id }}" hidden>
                    <div class="row">
                      <div class="col-md-6 col-sm-12">
                        <fieldset>
                          <input name="nickname" type="text" id="nickname" placeholder="Mời bạn nhập tên hiển thị" required>
                        </fieldset>
                      </div>
                      <div class="col-md-6 col-sm-12">
                        <fieldset>
                          <input name="email" type="text" id="email" placeholder="Mời bạn nhập địa chỉ email" required>
                        </fieldset>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          <textarea name="message" rows="6" id="message" placeholder="Mời bạn để lại bình luận..." required></textarea>
                        </fieldset>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          <button type="submit" id="form-submit" class="main-button">Gửi</button>
                        </fieldset>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
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

@section('Javascript')
<script type="text/javascript">
  function showReplyForm(commentId,user) {
    var x = document.getElementById(`reply-form-${commentId}`);
    var input = document.getElementById(`reply-form-${commentId}-text`);
    if (x.style.display === "none") {
      x.style.display = "block";
      x.scrollIntoView(false);
      input.innerText=`@${user} `;
    } else {
      x.style.display = "none";
    }
  }
</script>
@endsection