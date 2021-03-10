@extends('website.template.master')
@section('title')
    {{ $page->title}} - CungCodeNao
@endsection
@section('content')
  <section class="about-us">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <img src="{{ asset('storage/pages/' . $page->thumbnail) }}" alt="{{ $page->title }}">
          <div><br><hr>
            <h2>{{ $page->title }}</h2>
            <h4>{{ $page->sub_title }}</h4>
            {!! $page->details !!}
            <span style="float: right;">Đăng bởi: {{ $page->user->name }}  -  Vào ngày:  {{ date('M d Y', strtotime($page->created_at)) }} </span>
          </div>
        </div>
      </div>

    </div>
  </section>
</article>
@endsection