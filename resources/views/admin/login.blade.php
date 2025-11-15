<html lang="en" dir="ltr">
  <head>
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta content="" name="description">
    <meta content="" name="author">
    <meta name="keywords" content="">
    <!-- Title -->
    <title>Admin Login</title>
    <!--Favicon -->
    <link rel="icon" href="{{asset('public/assets/images/brand/favicon.ico')}}" type="image/x-icon">
    <!-- Bootstrap css -->
    <link href="{{asset('public/assets/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet" />

    <!-- Style css -->
    <link href="{{asset('public/assets/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/css/dark.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/css/skin-modes.css')}}" rel="stylesheet" />

    <!-- Animate css -->
    <link href="{{asset('public/assets/plugins/animated/animated.css')}}" rel="stylesheet" />
    <!---Icons css-->
    <link href="{{asset('public/assets/plugins/icons/icons.css')}}" rel="stylesheet" />
    <!-- Select2 css -->
    <link href="{{asset('public/assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet" />
    <!-- P-scroll bar css-->
    <link href="{{asset('public/assets/plugins/p-scrollbar/p-scrollbar.css')}}" rel="stylesheet" />
    <!-- INTERNAL Switcher css -->
    <link href="{{asset('public/assets/switcher/css/switcher.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/assets/switcher/demo.css')}}" rel="stylesheet"/>
    
    <meta http-equiv="imagetoolbar" content="no">
  </head>
  <body>
    <div class="page login-bg">
        <div class="page-single">
            <div class="container">
                <div class="row">
                    <div class="col mx-auto">
                        <div class="row justify-content-center">
                            <div class="col-md-7 col-lg-5">
                                <div class="card">
                                    <div class="p-4 pt-6 text-center">
                                        <h1 class="mb-2">Login</h1>
                                        <p class="text-muted">Sign In to your account</p>
                                    </div>
                                    <form class="card-body pt-3" id="login" name="login" method="post" action="{{URL::to('dologin')}}">
                                        @csrf
                                        <div class="form-group">
                                            <label class="form-label">Username</label>
                                            <input class="form-control" placeholder="Email" type="email" name="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Password</label>
                                            <input class="form-control" placeholder="password" type="password" name="password" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                                                <span class="custom-control-label">Remeber me</span>
                                            </label>
                                        </div>
                                        <div class="submit">
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Jquery js-->
    <script src="{{asset('public/assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap4 js-->
    <script src="{{asset('public/assets/plugins/bootstrap/popper.min.js')}}"></script>
    <script src="{{asset('public/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- Select2 js -->
    <script src="{{asset('public/assets/plugins/select2/select2.full.min.js')}}"></script>
    <!-- P-scroll js-->
    <script src="{{asset('public/assets/plugins/p-scrollbar/p-scrollbar.js')}}"></script>
    <!-- Custom js-->
    <!-- INTERNAL Notifications js -->
    <script src="{{asset('public/assets/plugins/notify/js/notifIt.js')}}"></script>

    <script src="{{asset('public/assets/js/custom.js')}}"></script>
    <!-- Switcher js -->
    <!-- <script src="{{asset('public/assets/switcher/js/switcher.js')}}"></script> -->
    <script type="text/javascript">
        @if(Session::has('success'))
            notif({
                msg: "{{ Session::get('success') }}",
                type: "success",
                position: "center"
            });
        @endif
        @if (Session::has('error'))
            notif({
                msg: "{{ Session::get('error') }}",
                type: "error",
                position: "center"
            });
        @endif
    </script>
  </body>
</html>