<?php
use App\Models\Identity;
use Illuminate\Support\Facades\App;
use App\Models\Service;
use App\Models\Branch;
use App\Models\Social;

 $base = Request::path();
 /*
if(($base== URL::to('/') ) || ($base==url(App::currentLocale())) ){
    $base="";
}*/


?>
<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    @include('account.partials.main-styles')
    <title>@yield('title')</title>
    <meta name="description"
          content="@yield('description')">
    <!-- LOAD CSS FILES -->
    <link href="{{URL::asset('front/front/css/main_'.App::currentLocale().'.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{URL::asset('front/front/css/custom-onepage.css')}}" />
    <!-- All Plugins Css -->
    <link rel="stylesheet" href="{{URL::asset('front/assets/css/plugins.css')}}">
    <link rel="stylesheet" href="{{URL::asset('front/assets/css/nav_'.App::currentLocale().'.css')}}" />


    <!-- Custom CSS -->
    <link href="{{URL::asset('front/assets/css/styles_'.App::currentLocale().'.css')}}" rel="stylesheet">

    <!-- Custom Color Option -->
    <link href="{{URL::asset('front/assets/css/colors.css')}}" rel="stylesheet">
    <link href="{{URL::asset('front/css/cost.css')}}" rel="stylesheet">


    <!-- LOAD CSS FILES -->


</head>

<body  <?= (App::currentLocale()=='en')? 'dir="ltr"': 'dir="rtl" '?> class="green-skin" >
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div id="preloader"><div class="preloader"><span></span><span></span></div></div>



<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">

    <!-- ============================================================== -->
    <!-- Top header  -->
   
    <!-- ============================================================== -->
    <!-- Start Navigation -->
    <div class="header header-light ">
        <nav class="headnavbar ">
            <div class="nav-header">
                <a href="{{ url(App::currentLocale().'/') }}" class="brand"><img style="width: 108px; height: 44px;"src="{{URL::asset('front/assets/img/logo-light.png')}}" alt="" /></a>
                <button class="toggle-bar"><span class="ti-align-justify"></span></button>
            </div>
            <ul class="menu arabic">

                <li><a {!! ($base=='home'|| $base==url() ||$base==url(App::currentLocale())  )? 'class="active"' :'' !!} href="{{ url(App::currentLocale().'/') }}">{{__('front.home')}}</a></li>
                <li class="dropdown">
                    <a {!! ($base=='services')? 'class="active"' :'' !!} href="{{ url(App::currentLocale().'/services') }}">{{__('front.services')}}</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url(App::currentLocale().'/services') }}">{{__('front.services')}}</a></li>
                        <?php
                        $services = Service::limit(6)->get(); // return collection
                        $services->makeHidden(['resource_url']);
                        //$services->title['en']
                        ?>
                        @foreach($services as $service)
                            <li><a href="{{ url(App::currentLocale().'/service/'.$service->id) }}">{{ $service->title  }}</a></li>
                        @endforeach
                    </ul>
                </li>
                 <li><a {!! ($base=='about' )? 'class="active"' : '' !!} href="{{ url(App::currentLocale().'/about') }}">{{__('front.about')}}</a></li>
                        <li><a {!! ($base=='career' )? 'class="active"' : '' !!} href="{{ url(App::currentLocale().'/career') }}">{{__('front.careers')}}</a></li>
                        <li><a {!! ($base=='pricing' )? 'class="active"' : '' !!} href="{{ url(App::currentLocale().'/pricing') }}">{{__('front.price')}}</a></li>
                        <li><a {!! ($base=='contact' )? 'class="active"' : '' !!} href="{{ url(App::currentLocale().'/contact') }}">{{__('front.contact')}}</a></li>
            </ul>

            <ul class="attributes">
                        <li class="dropdown"> <a class="btn btn-order-by-filt">@if(Auth::check() && Auth::user()->avatar_thumb_url)
                        <img src="{{ Auth::user()->avatar_thumb_url }}" class="avatar-img">
                    @elseif(Auth::check() && Auth::user()->first_name && Auth::user()->last_name)
                        <span class="avatar-initials">{{ mb_substr(Auth::user()->first_name, 0, 1) }}{{ mb_substr(Auth::user()->last_name, 0, 1) }}</span>
                    @elseif(Auth::check() && Auth::user()->name)
                        <span class="avatar-initials">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                    @elseif(Auth::guard(config('account-auth.defaults.guard'))->check() && Auth::guard(config('account-auth.defaults.guard'))->user()->first_name && Auth::guard(config('account-auth.defaults.guard'))->user()->last_name)
                        <span class="avatar-initials">{{ mb_substr(Auth::guard(config('account-auth.defaults.guard'))->user()->first_name, 0, 1) }}{{ mb_substr(Auth::guard(config('account-auth.defaults.guard'))->user()->last_name, 0, 1) }}</span>
                    @else
                        <span class="avatar-initials"><i class="ti-user"></i></span>
                    @endif

                    @if(!is_null(config('account-auth.defaults.guard')))
                        <span class="hidden-md-down">{{ Auth::guard(config('account-auth.defaults.guard'))->check() ? Auth::guard(config('account-auth.defaults.guard'))->user()->full_name : 'Anonymous' }}</span>
                    @else
                        <span class="hidden-md-down">{{ Auth::check() ? Auth::user()->full_name : 'Anonymous' }}</span>
                    @endif</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('account/profile') }}"><i class="ti-user"></i>{{ trans('brackets/admin-auth::admin.profile_dropdown.profile') }}</a></li>
                                <li><a href="{{ url('account/password') }}"><i class="ti-unlock"></i>{{ trans('brackets/admin-auth::admin.profile_dropdown.password') }}</a></li>
                                <li><a class="active" href="{{ url('account/logout') }}"><i class="ti-power-off"></i>{{ trans('brackets/admin-auth::admin.profile_dropdown.logout') }}</a></li>
                            </ul>
                        </li>
                    </ul>
            <!--ul class="attributes attributes-desk">
                <li class="log-icon log-seprate"><a href="#" data-toggle="modal" data-target="#login">{{__('front.login')}}</a></li>
                <li class="log-icon"><a href="#" data-toggle="modal" data-target="#signup">{{__('front.signup')}}</a></li>
                <li class="submit-attri theme-log"><a href="{{ url((App::currentLocale()=='en')? 'ar/': 'en/')}}/{{ $base }}"><?= (App::currentLocale()=='en')? 'العربية': 'English'?></a></li>

            </ul-->

        </nav>
    </div>
    <!-- End Navigation -->
    <div class="clearfix"></div>


    <!-- ============================================================== -->
    <!-- Top header  -->
    <!-- ============================ Page Title Start================================== -->
            <!--div class="page-title">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            
                            <h2 class="ipt-title">Welcome!</h2>
                            <span class="ipn-subtitle">Welcome To Your Account</span>
                            
                        </div>
                    </div>
                </div>
            </div-->
            <!-- ============================ Page Title End ================================== -->
                <!-- ============================ User Dashboard ================================== -->
            <section style="padding-top: 40px !important;">
                <div id="app" class="container" style="max-width:100% !important;">
                    <div class="row">
                        
                        <div class="col-lg-3 col-md-12">
                            <div class="dashboard-navbar">
                                
                                <div class="d-user-avater">
                                    @if(Auth::guard(config('account-auth.defaults.guard'))->check() && Auth::user()->avatar_thumb_url)
                        <img src="{{ Auth::user()->avatar_thumb_url }}" class="avatar-img">
                    @elseif(Auth::guard(config('account-auth.defaults.guard'))->check() && Auth::user()->first_name && Auth::user()->last_name)
                        <span class="avatar-profile ">{{ mb_substr(Auth::user()->first_name, 0, 1) }}{{ mb_substr(Auth::user()->last_name, 0, 1) }}</span>
                    @elseif(Auth::check() && Auth::user()->name)
                        <span class="avatar-profile ">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                    @elseif(Auth::guard(config('account-auth.defaults.guard'))->check() && Auth::guard(config('account-auth.defaults.guard'))->user()->first_name && Auth::guard(config('account-auth.defaults.guard'))->user()->last_name)
                        <span class="avatar-initials">{{ mb_substr(Auth::guard(config('account-auth.defaults.guard'))->user()->first_name, 0, 1) }}{{ mb_substr(Auth::guard(config('account-auth.defaults.guard'))->user()->last_name, 0, 1) }}</span>
                    @else
                        <span class="avatar-profile "><i class="ti-user"></i></span>
                    @endif

                    @if(!is_null(config('account-auth.defaults.guard')))
                        <h4>{{ Auth::guard(config('account-auth.defaults.guard'))->check() ? Auth::guard(config('account-auth.defaults.guard'))->user()->full_name : 'Anonymous' }}</h4>
                    @else
                        <h4 >{{ Auth::check() ? Auth::user()->full_name : 'Anonymous' }}</h4>
                    @endif
                                    
                                </div>
                                
                                <div class="d-navigation">
                                    <ul>
                                        <li {!!  ($base=='profile')? 'class="active"' :'' !!}><a href="{{ url('account/profile') }}"><i class="ti-user"></i>{{ trans('brackets/admin-auth::admin.profile_dropdown.profile') }}</a></li>
                                        <li><a href="{{ url('account/shipments') }}"><i class="ti-bookmark"></i>Shipment Listings</a></li>
                                        <li><a href="my-property.html"><i class="ti-layers"></i>calculate</a></li>
                                        <li><a href="my-property.html"><i class="ti-layers"></i>track</a></li>
                                        <li><a href="submit-property.html"><i class="ti-pencil-alt"></i>walat</a></li>
                                        <li><a href="submit-property.html"><i class="ti-pencil-alt"></i>places</a></li>
                                        <li><a href="submit-property.html"><i class="ti-pencil-alt"></i>transeactions</a></li>
                                        <li><a href="{{ url('account/password') }}"><i class="ti-unlock"></i>{{ trans('brackets/admin-auth::admin.profile_dropdown.password') }}</a></li>
                                        <li><a href="{{ url('account/logout') }}"><i class="ti-power-off"></i>{{ trans('brackets/admin-auth::admin.profile_dropdown.logout') }}</a></li>
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                        
                        @yield('content')
                        
                    </div>
                </div>
            </section>
            <!-- ============================ User Dashboard End ================================== -->
    <!-- ============================================================== -->
        
    
    <!-- ============================ Footer Start ================================== -->
    <footer class="dark-footer skin-dark-footer">
        
        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center <?= (App::currentLocale()=='en')? '': 'arabic" '?>">

                    <div class="col-lg-6 col-md-6 text-center">
                        <p class="mb-0">© 2021 - Icode Media </p>
                    </div>
                    <div class="col-lg-6 col-md-6 text-center">
                        <ul class="footer-bottom-social">
                            <?php  $social = Social::limit(5)->get(); // return collection
                            $social->makeHidden(['resource_url']); ?>
                            @foreach($social as $social )
                                <li><a href="{{ $social['link'] }}"><i class="{{ str_replace("fa-","lni-",$social['icon']) }}"></i></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- ============================ Footer End ================================== -->

   
    <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>


</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
@include('account.partials.main-bottom-scripts')
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{URL::asset('front/assets/js/jquery.min.js')}}"></script>
<script src="{{URL::asset('front/assets/js/popper.min.js')}}"></script>
<script src="{{URL::asset('front/assets/js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('front/assets/js/rangeslider.js')}}"></script>
<script src="{{URL::asset('front/assets/js/select2.min.js')}}"></script>
<script src="{{URL::asset('front/assets/js/aos.js')}}"></script>

<script src="{{URL::asset('front/assets/js/owl.carousel.min.js')}}"></script>

<script src="{{URL::asset('front/assets/js/jquery.magnific-popup.min.js')}}"></script>

<script src="{{URL::asset('front/assets/js/slick.js')}}"></script>
<script src="{{URL::asset('front/assets/js/slider-bg.js')}}"></script>
<script src="{{URL::asset('front/assets/js/lightbox.js')}}"></script>
<script src="{{URL::asset('front/assets/js/imagesloaded.js')}}"></script>

<script src="{{URL::asset('front/assets/js/isotope.min.js')}}"></script>

<script src="{{URL::asset('front/assets/js/coreNavigation.js')}}"></script>
<script src="{{URL::asset('front/assets/js/custom.js')}}"></script>


<!-- LOAD JS FILES -->
<script src="{{URL::asset('front/front/js/easing.js')}}"></script>
<script src="{{URL::asset('front/front/js/jquery.ui.totop.js')}}"></script>
<!--script src="{{URL::asset('front/front/js/selectnav.js')}}"></script-->
<script src="{{URL::asset('front/front/js/ender.js')}}"></script>
<!--script src="{{URL::asset('front/front/js/owl.carousel.js')}}"></script-->
<script src="{{URL::asset('front/front/js/jquery.fitvids.js')}}"></script>
<script src="{{URL::asset('front/front/js/jquery.plugin.js')}}"></script>
<script src="{{URL::asset('front/front/js/wow.min.js')}}"></script>
<!--script src="{{URL::asset('front/front/js/jquery.magnific-popup.min.js')}}"></script-->
<script src="{{URL::asset('front/front/js/tweecool.js')}}"></script>
<script src="{{URL::asset('front/front/js/jquery.stellar.js')}}"></script>
<script src="{{URL::asset('front/front/js/typed.js')}}"></script>

<!-- theme custom and plugin settings -->
<script src="{{URL::asset('front/js/rang.js')}}"></script>
<script src="{{URL::asset('front/front/js/custom.js')}}"></script>
<script src="{{URL::asset('front/front/js/custom-tweecool.js')}}"></script>

<!-- script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="{{URL::asset('front/js/map-blue-1.js')}}"></script>
<script src="{{URL::asset('front/js/map-2.js')}}"></script>
<script src="{{URL::asset('front/js/map-3.js')}}"></script>

<script src="{{URL::asset('site/js/calco.js')}}"></script-->
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->

</body>
</html>
