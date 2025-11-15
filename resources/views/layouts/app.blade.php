<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta content="DayOne - It is one of the Major Dashboard Template which includes - HR, Employee and Job Dashboard. This template has multipurpose HTML template and also deals with Task, Project, Client and Support System Dashboard." name="description">
    <meta content="Spruko Technologies Private Limited" name="author">
    <meta name="keywords" content="admin dashboard, dashboard ui, backend, admin panel, admin template, dashboard template, admin, bootstrap, laravel, laravel admin panel, php admin panel, php admin dashboard, laravel admin template, laravel dashboard, laravel admin panel"/>

    <!-- Title -->
    <title>@yield('title')</title>

        <!--Favicon -->
    <link rel="icon" href="{{asset('public/assets/images/brand/favicon.ico')}}" type="image/x-icon"/>

    <!-- Bootstrap css -->
    <link href="{{asset('public/assets/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet" />

    <!-- Style css -->
    <link href="{{asset('public/assets/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/css/dark.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/css/skin-modes.css')}}" rel="stylesheet" />

    <!-- Animate css -->
    <link href="{{asset('public/assets/plugins/animated/animated.css')}}" rel="stylesheet" />

    <!--Sidemenu css -->
    <link  href="{{asset('public/assets/css/sidemenu.css')}}" rel="stylesheet">

    <!-- P-scroll bar css-->
    <link href="{{asset('public/assets/plugins/p-scrollbar/p-scrollbar.css')}}" rel="stylesheet" />

    <!---Icons css-->
    <link href="{{asset('public/assets/plugins/icons/icons.css')}}" rel="stylesheet" />

    <!---Sidebar css-->
    <link href="{{asset('public/assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet" />

    <!-- Select2 css -->
    <link href="{{asset('public/assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />

    <!-- INTERNAL Fancy File Upload css -->
    <link href="{{asset('public/assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/plugins/fileupload/css/fileupload.css')}}" rel="stylesheet" type="text/css" />

    <!-- INTERNAL Gallery css -->
    <link href="{{asset('public/assets/plugins/lightgallery/gallery.css')}}" rel="stylesheet">

    <!-- <link href="{{asset('public/assets/plugins/notify/css/jquery.growl.css')}}" rel="stylesheet" /> -->
    <link href="{{asset('public/assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet" />
        
    <!-- INTERNAL Data table css -->
    <link href="{{asset('public/assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
    <link href="{{asset('public/assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

    <!-- INTERNAL Pg-calendar-master css -->
    <link href="{{asset('public/assets/plugins/pg-calendar-master/pignose.calendar.css')}}" rel="stylesheet" />


        <!-- INTERNAL Switcher css -->
    <link href="{{asset('public/assets/switcher/css/switcher.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/assets/switcher/demo.css')}}" rel="stylesheet"/>

  </head>

  <body class="app sidebar-mini" id="index1">
    <!---Global-loader-->
    <div id="global-loader" >
      <img src="{{asset('public/assets/images/svgs/loader.svg')}}" alt="loader">
    </div>

    <div class="page">
      <div class="page-main">

        <!--aside open-->
        <aside class="app-sidebar">
          <div class="app-sidebar__logo">
            <a class="header-brand" href="index.html">
              <img src="{{asset('public/assets/images/brand/logo.png')}}" class="header-brand-img desktop-lgo" alt="Dayonelogo">
              <img src="{{asset('public/assets/images/brand/logo-white.png')}}" class="header-brand-img dark-logo" alt="Dayonelogo">
              <img src="{{asset('public/assets/images/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Dayonelogo">
              <img src="{{asset('public/assets/images/brand/favicon1.png')}}" class="header-brand-img darkmobile-logo" alt="Dayonelogo">
            </a>
          </div>
          <div class="app-sidebar3">
            <ul class="side-menu">
                <li class="side-item side-item-category mt-4">Dashboards</li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{URL::to('dashboard')}}">
                        <i class="feather feather-home sidemenu_icon"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{URL::to('users')}}">
                        <i class="feather feather-users sidemenu_icon"></i>
                        <span class="side-menu__label">Users</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{URL::to('membership')}}">
                        <i class="feather feather-shopping-cart sidemenu_icon"></i>
                        <span class="side-menu__label">Users Membership</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{URL::to('packages')}}">
                        <i class="fe fe-inbox sidemenu_icon"></i>
                        <span class="side-menu__label">Credit Packages</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{URL::to('abuse_report')}}">
                        <i class="fe fe-flag sidemenu_icon"></i>
                        <span class="side-menu__label">Abuse Reports</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{URL::to('notification')}}">
                        <i class="fe fe-bell sidemenu_icon"></i>
                        <span class="side-menu__label">Notification</span>
                    </a>
                </li>
              <!-- <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                  <i class="feather feather-home sidemenu_icon"></i>
                  <span class="side-menu__label">HR Dashboard</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                  <li><a href="index.html" class="slide-item">Dashboard</a></li>
                  <li><a href="hr-department.html" class="slide-item">Department</a></li>
                  <li class="sub-slide">
                    <a class="sub-side-menu__item" data-toggle="sub-slide" href="#"><span class="sub-side-menu__label">Employees</span><i class="sub-angle fa fa-angle-right"></i></a>
                    <ul class="sub-slide-menu">
                      <li><a class="sub-slide-item" href="hr-emplist.html">Employees List</a></li>
                      <li><a class="sub-slide-item" href="hr-empview.html">View Employee</a></li>
                      <li><a class="sub-slide-item" href="hr-addemployee.html">Add Employee</a></li>
                    </ul>
                  </li>
                  <li class="sub-slide">
                    <a class="sub-side-menu__item" data-toggle="sub-slide" href="#"><span class="sub-side-menu__label">Attendance</span><i class="sub-angle fa fa-angle-right"></i></a>
                    <ul class="sub-slide-menu">
                      <li><a class="sub-slide-item" href="hr-attlist.html">Attendance List</a></li>
                      <li><a class="sub-slide-item" href="hr-attuser.html">Attendance By User</a></li>
                      <li><a class="sub-slide-item" href="hr-attview.html">Attendance View</a></li>
                      <li><a class="sub-slide-item" href="hr-overviewcldr.html">Overview Calender</a></li>
                      <li><a class="sub-slide-item" href="hr-attmark.html">Attendance Mark </a></li>
                      <li><a class="sub-slide-item" href="hr-leaves.html">Leave Settings</a></li>
                      <li><a class="sub-slide-item" href="hr-leavesapplication.html">Leave Applications</a></li>
                      <li><a class="sub-slide-item" href="hr-recentleaves.html">Recent Leaves </a></li>
                    </ul>
                  </li>
                  <li><a href="hr-award.html" class="slide-item">Awards</a></li>
                  <li><a href="hr-holiday.html" class="slide-item">Holidays</a></li>
                  <li><a href="hr-notice.html" class="slide-item">Notice Board</a></li>
                  <li><a href="hr-expenses.html" class="slide-item">Expenses</a></li>
                  <li class="sub-slide">
                    <a class="sub-side-menu__item" data-toggle="sub-slide" href="#"><span class="sub-side-menu__label">Payroll</span><i class="sub-angle fa fa-angle-right"></i></a>
                    <ul class="sub-slide-menu">
                      <li><a class="sub-slide-item" href="hr-empsalary.html">Employee Salary</a></li>
                      <li><a class="sub-slide-item" href="hr-addpayroll.html">Add Payroll</a></li>
                      <li><a class="sub-slide-item" href="hr-editpayroll.html">Edit Payroll</a></li>
                    </ul>
                  </li>
                  <li><a href="hr-events.html" class="slide-item">Events</a></li>
                  <li><a href="hr-settings.html" class="slide-item">Settings</a></li>
                </ul>
              </li> -->
              
            </ul>
          </div>
        </aside>
        <!--aside closed-->

        <div class="app-content main-content">
            <div class="side-app">

                <!--app header-->
                <div class="app-header header">
                  <div class="container-fluid">
                    <div class="d-flex">
                      <a class="header-brand" href="index.html">
                        <img src="{{asset('public/assets/images/brand/logo.png')}}" class="header-brand-img desktop-lgo" alt="Dayonelogo">
                        <img src="{{asset('public/assets/images/brand/logo-white.png')}}" class="header-brand-img dark-logo" alt="Dayonelogo">
                        <img src="{{asset('public/assets/images/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Dayonelogo">
                        <img src="{{asset('public/assets/images/brand/favicon1.png')}}" class="header-brand-img darkmobile-logo" alt="Dayonelogo">
                      </a>
                      <div class="app-sidebar__toggle" data-toggle="sidebar">
                        <a class="open-toggle" href="#">
                          <i class="feather feather-menu"></i>
                        </a>
                        <a class="close-toggle" href="#">
                          <i class="feather feather-x"></i>
                        </a>
                      </div>
                      <div class="d-flex order-lg-2 my-auto ml-auto">
                        
                        <div class="dropdown header-fullscreen">
                          <a class="nav-link icon full-screen-link">
                            <i class="feather feather-maximize fullscreen-button fullscreen header-icons"></i>
                            <i class="feather feather-minimize fullscreen-button exit-fullscreen header-icons"></i>
                          </a>
                        </div>
                        
                        
                        <div class="dropdown profile-dropdown">
                          <a href="#" class="nav-link pr-1 pl-0 leading-none" data-toggle="dropdown">
                            <span>
                              <img src="{{asset('public/assets/images/users/16.jpg')}}" alt="img" class="avatar avatar-md bradius">
                            </span>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated">
                            <div class="p-3 text-center border-bottom">
                                <a href="#" class="text-center user pb-0 font-weight-bold">{{ucfirst(Auth::user()->name)}}</a>
                                <!-- <p class="text-center user-semi-title">App Developer</p> -->
                            </div>
                            <a class="dropdown-item d-flex" href="{{URL::to('profile')}}">
                                <i class="feather feather-user mr-3 fs-16 my-auto"></i>
                                <div class="mt-1">Profile</div>
                            </a>
                            <!-- <a class="dropdown-item d-flex" href="#">
                                <i class="feather feather-settings mr-3 fs-16 my-auto"></i>
                                <div class="mt-1">Settings</div>
                            </a>
                            <a class="dropdown-item d-flex" href="#">
                                <i class="feather feather-mail mr-3 fs-16 my-auto"></i>
                                <div class="mt-1">Messages</div>
                            </a> -->
                            <a class="dropdown-item d-flex" href="{{URL::to('password')}}">
                                <i class="feather feather-edit-2 mr-3 fs-16 my-auto"></i>
                                <div class="mt-1">Change Password</div>
                            </a>
                            <a class="dropdown-item d-flex" href="{{URL::to('logout')}}">
                                <i class="feather feather-power mr-3 fs-16 my-auto"></i>
                                <div class="mt-1">Sign Out</div>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/app header-->

                @yield('content')

            </div>
        </div><!-- end app-content-->
      </div>

            <!--Footer-->
      <footer class="footer">
        <div class="container">
          <div class="row align-items-center flex-row-reverse">
            <div class="col-md-12 col-sm-12 mt-3 mt-lg-0 text-center">
              <!-- Copyright © 2021 <a href="#">Dayone</a>. Designed by <a href="#">Spruko Technologies Pvt.Ltd</a> All rights reserved. -->
            </div>
          </div>
        </div>
      </footer>
      <!-- End Footer-->
    </div>

        <!-- Back to top -->
    <a href="#top" id="back-to-top"><span class="feather feather-chevrons-up"></span></a>

    <!--Moment js-->
    <script src="{{asset('public/assets/plugins/moment/moment.js')}}"></script>

    <!-- Jquery js-->
    <script src="{{asset('public/assets/plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap4 js-->
    <script src="{{asset('public/assets/plugins/bootstrap/popper.min.js')}}"></script>
    <script src="{{asset('public/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

    <!--Othercharts js-->
    <script src="{{asset('public/assets/plugins/othercharts/jquery.sparkline.min.js')}}"></script>

    <!-- Circle-progress js-->
    <script src="{{asset('public/assets/plugins/circle-progress/circle-progress.min.js')}}"></script>

    <!--Sidemenu js-->
    <script src="{{asset('public/assets/plugins/sidemenu/sidemenu.js')}}"></script>

    <!-- P-scroll js-->
    <!-- <script src="{{asset('public/assets/plugins/p-scrollbar/p-scrollbar.js')}}"></script> -->
    <!-- <script src="{{asset('public/assets/plugins/p-scrollbar/p-scroll1.js')}}"></script> -->

    <!--Sidebar js-->
    <!-- <script src="{{asset('public/assets/plugins/sidebar/sidebar.js')}}"></script> -->

    <!-- Select2 js -->
    <script src="{{asset('public/assets/plugins/select2/select2.full.min.js')}}"></script>

        
    <!-- INTERNAL Chart js -->
    <script src="{{asset('public/assets/plugins/chart/chart.bundle.js')}}"></script>
    <script src="{{asset('public/assets/plugins/chart/utils.js')}}"></script>

    <!-- INTERNAL Apexchart js-->
    <script src="{{asset('public/assets/plugins/apexchart/apexcharts.js')}}"></script>

    <!-- INTERNAL Data tables -->
    <!-- <script src="{{asset('public/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('public/assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('public/assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script> -->

    <script src="{{asset('public/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('public/assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{asset('public/assets/plugins/datatable/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('public/assets/plugins/datatable/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('public/assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('public/assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('public/assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('public/assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/assets/js/datatables.js')}}"></script>

    <!-- INTERNAL Gallery js -->
    <script src="{{asset('public/assets/plugins/lightgallery/picturefill.js')}}"></script>
    <script src="{{asset('public/assets/plugins/lightgallery/lightgallery.js')}}"></script>
    <script src="{{asset('public/assets/plugins/lightgallery/lg-pager.js')}}"></script>
    <script src="{{asset('public/assets/plugins/lightgallery/lg-autoplay.js')}}"></script>
    <script src="{{asset('public/assets/plugins/lightgallery/lg-fullscreen.js')}}"></script>
    <script src="{{asset('public/assets/plugins/lightgallery/lg-zoom.js')}}"></script>
    <script src="{{asset('public/assets/plugins/lightgallery/lg-hash.js')}}"></script>
    <script src="{{asset('public/assets/plugins/lightgallery/lg-share.js')}}"></script>
    <script src="{{asset('public/assets/js/gallery.js')}}"></script>
    
    <!-- INTERNAL File uploads js -->
    <script src="{{asset('public/assets/plugins/fileupload/js/dropify.js')}}"></script>
    <script src="{{asset('public/assets/js/filupload.js')}}"></script>

    <!-- INTERNAL Pg-calendar-master js -->
    <!-- <script src="{{asset('public/assets/plugins/pg-calendar-master/pignose.calendar.full.min.js')}}"></script> -->

    <!-- INTERNAL Index js-->
    <!-- <script src="{{asset('public/assets/js/index4.js')}}"></script> -->
    <!-- <script src="{{asset('public/assets/js/project/project-sidemenuchart.js')}}"></script> -->

    <!-- INTERNAL Notifications js -->
    <script src="{{asset('public/assets/plugins/notify/js/notifIt.js')}}"></script>

    <!-- INTERNAL Index js-->
    <script src="{{asset('public/assets/js/hr/hr-emp.js')}}"></script>
    <!-- Custom js-->
    <script src="{{asset('public/assets/js/custom.js')}}"></script>

        <!-- Switcher js -->
    <script src="{{asset('public/assets/switcher/js/switcher.js')}}"></script>
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
    @yield('customjs')
  </body>
</html>