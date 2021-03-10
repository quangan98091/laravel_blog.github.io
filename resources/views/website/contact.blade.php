@extends('website.template.master')
@section('title')
    Góp ý - CungCodeNao
@endsection

@section('content') 
  <section class="call-to-action">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="main-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 0 10px 0px black; background-image: url('{{ asset('website/assets/images/cta-bg.jpg') }}')" alt="Ảnh">
            <span style="color: white;">CungCodeNao xin hân hạnh được giúp đỡ bạn.</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section style="margin-top: 31px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(Session::has('message'))
                    <div class="alert alert-success"> {{Session('message')}}</div>
                @endif
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8" style="border: 1px solid #00000054; border-radius: 12px; overflow: hidden; box-shadow: 0 0 16px #151514; padding: 19px 22px;">
                {!! Form::open(['route' => 'contact.submit']) !!}
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>Tên hiển thị</label>
                        <input type="text" name="name" class="form-control" id="name" required
                               data-validation-required-message="Tên hiển thị không được để trống.">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>Địa chỉ email</label>
                        <input type="email" name="email" class="form-control" id="email" required
                               data-validation-required-message="Địa chỉ email không được để trống.">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Số điện thoại</label>
                        <input type="tel" name="tel" class="form-control" id="phone" required
                               data-validation-required-message="Số điện thoại không được để trống.">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>Nội dung góp ý</label>
                        <textarea rows="5" name="message" class="form-control" id="message" required
                                  data-validation-required-message="Nội dung góp ý không được để trống"></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <br>
                <div id="success"></div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary float-right" id="sendMessageButton">Gửi góp ý</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
  </section>

@endsection