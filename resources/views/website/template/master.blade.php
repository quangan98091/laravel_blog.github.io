<!DOCTYPE html>
<html lang="vi">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">

    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('website/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('website/assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/css/templatemo-stand-blog.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/css/owl.css') }}">

  </head>

  <body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header style="background: rgb(102 140 121 / 51%);">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="{{ url('/') }}"><h2>CungCodeNao<em>.</em></h2></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                @php($pages = getPages())
                @foreach($pages as $page)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('page/' . $page->slug) }}">{{ $page->title }}</a>
                    </li>
                @endforeach

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact.show') }}">Góp ý</a>
                </li>
                
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <br><br>
    

    @yield('content')
     
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <ul class="social-icons">
              <li><a href="#">Facebook</a></li>
              <li><a href="#">Twitter</a></li>
              <li><a href="#">Gmail</a></li>
              <li><a href="#">Youtube</a></li>
            </ul>
          </div>
          <div class="col-md-12">
            <div class="copyright-text">
                <p>Copyright &copy; CungCodeNao.</p>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('website/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('website/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Additional Scripts -->
    <script src="{{ asset('website/assets/js/custom.js') }}"></script>
    <script src="{{ asset('website/assets/js/owl.js') }}"></script>
    <script src="{{ asset('website/assets/js/slick.js') }}"></script>
    <script src="{{ asset('website/assets/js/isotope.js') }}"></script>
    <script src="{{ asset('website/assets/js/accordions.js') }}"></script>

    <script language = "text/Javascript"> 
      cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
      function clearField(t){                   //declaring the array outside of the
      if(! cleared[t.id]){                      // function makes it static and global
          cleared[t.id] = 1;  // you could use true and false, but that's more typing
          t.value='';         // with more chance of typos
          t.style.color='#fff';
          }
      }
    </script>

    @yield('Javascript')
  </body>
</html>