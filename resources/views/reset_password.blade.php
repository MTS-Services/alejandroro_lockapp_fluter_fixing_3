<html lang="en" dir="ltr">
  <head>
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta content="" name="description">
    <meta content="" name="author">
    <meta name="keywords" content="">
    <!-- Title -->
    <title>Reset Password</title>
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
                                        <h1 class="mb-2">Reset Password</h1>
                                        <p class="text-muted">Reset Password to your account</p>
                                    </div>
                                    <form class="card-body pt-3" method="post" action="{{route('post:reset_password')}}">
                                        @csrf
                                        <input type="hidden" name="token" value="{{$token}}">
                                        <div class="form-group">
                                            <label class="form-label">New Password</label>
                                            <input class="form-control" placeholder="password" type="password" name="new_password" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Confirm Password</label>
                                            <input class="form-control" placeholder="password" type="password" name="confirm_password" required>
                                        </div>
                                        <div class="">
                                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
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
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                notif({
                    msg: "{{ $error }}",
                    type: "error",
                    position: "center"
                });
            @endforeach
        @endif
    </script>
  </body>
</html>