@extends('layouts.front')

@section('title', trans('account.login.title'))

@section('content')
	<div class="container" id="app">
	    <div class="row align-items-center justify-content-center auth">
	        <div class="col-md-6 col-lg-5">
				<div class="card">
					<div class="card-block">
					<div class="modal-body">
                    <h4 class="modal-header-title">Log In</h4>
                    <div class="login-form">
                        @include('front.login')
                    </div>
                    <div class="modal-divider"><span>Or login via</span></div>
                    <div class="social-login mb-3">
                        <ul>
                            <li><a href="#" class="btn connect-fb"><i class="ti-facebook"></i>Facebook</a></li>
                            <li><a href="#" class="btn connect-twitter"><i class="ti-twitter"></i>Twitter</a></li>
                        </ul>
                    </div>
                    <div class="text-center">
                        <p class="mt-5"><a href="#" class="link">Forgot password?</a></p>
                    </div>
                </div>
					</div>
				</div>
	        </div>
	        <div class="col-md-6 col-lg-7">
				<div class="card">
					<div class="card-block">
					<div class="modal-body">
                    <h4 class="modal-header-title">Sign Up</h4>
                    <div class="login-form">
                        @include('front.register')
                    </div>
                    <div class="modal-divider"><span>Or login via</span></div>
                    <div class="social-login mb-3">
                        <ul>
                            <li><a href="#" class="btn connect-fb"><i class="ti-facebook"></i>Facebook</a></li>
                            <li><a href="#" class="btn connect-twitter"><i class="ti-twitter"></i>Twitter</a></li>
                        </ul>
                    </div>
                    <div class="text-center">
                        <p class="mt-5"><i class="ti-user mr-1"></i>Already Have An Account? <a href="#" class="link">Go For LogIn</a></p>
                    </div>
                </div>
					</div>
				</div>
	        </div>
	    </div>
	</div>

@endsection


@section('bottom-scripts')
<script type="text/javascript">
    // fix chrome password autofill
    // https://github.com/vuejs/vue/issues/1331
    document.getElementById('password').dispatchEvent(new Event('input'));
</script>
@endsection
