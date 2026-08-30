@push('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endpush
@extends('Auth.layout')
@section('contain')
    <div class="">
        <div class="text-center mb-3">
            <h2 class="mb-2">Sign In</h2>
            <p class="mb-0">Please enter your details to sign in</p>
        </div>
        <form>
            <div class="mb-3">
                <label class="form-label">Staff Code</label>
                <div class="input-group">
                    <input type="text" class="form-control border-end-0" autocomplete="off" id="user_name" name="user_name">
                    <span class="input-group-text border-start-0">
                        <i class="ti ti-mail"></i>
                    </span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="pass-group">
                    <input type="password" class="pass-input form-control" id="user_pass" autocomplete="off" name="user_pass">
                    <span class="ti toggle-password ti-eye-off"></span>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center">
                    <div class="form-check form-check-md mb-0">
                        <input class="form-check-input" id="remember_me" type="checkbox">
                        <label for="remember_me" class="form-check-label mt-0">Remember Me</label>
                    </div>
                </div>
                <div class="text-end">
                    <a href="#" class="link-danger">Forgot Password?</a>
                </div>
            </div>
            <div class="mb-3">
                <button type="button" onclick="proc_login();" class="btn btn-primary w-100">Sign In</button>
            </div>
        </form>
        {{-- <div class="text-center">
	<h6 class="fw-normal text-dark mb-0">Don’t have an account? 
		<a href="#" class="hover-a"> Create Account</a>
	</h6>
</div> --}}
        {{-- <div class="login-or">
	<span class="span-or">Or</span>
</div>
<div class="mt-2">
	<div class="d-flex align-items-center justify-content-center flex-wrap">
		<div class="text-center me-2 flex-fill">
			<a href="javascript:void(0);"
				class="br-10 p-2 btn btn-info d-flex align-items-center justify-content-center">
				<img class="img-fluid m-1" src="{{asset('/assets/img/icons/facebook-logo.svg')}}" alt="Facebook">
			</a>
		</div>
		<div class="text-center me-2 flex-fill">
			<a href="javascript:void(0);"
				class="br-10 p-2 btn btn-outline-light border d-flex align-items-center justify-content-center">
				<img class="img-fluid m-1" src="{{asset('/assets/img/icons/google-logo.svg')}}" alt="Facebook">
			</a>
		</div>
		<div class="text-center flex-fill">
			<a href="javascript:void(0);"
				class="bg-dark br-10 p-2 btn btn-dark d-flex align-items-center justify-content-center">
				<img class="img-fluid m-1" src="{{asset('/assets/img/icons/apple-logo.svg')}}" alt="Apple">
			</a>
		</div>
	</div>
</div> --}}
    </div>
@endsection

@push('script')
    <script>
        baseUrl = "{{ url('/') }}";
        secretKey = "{{config('app.key')}}";
    </script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{asset('assets/js/crypto.min.js')}}"></script>
    <script src="{{ asset('assets/js/auth/auth.js') }}"></script>
    <script>
        $(".select2").select2();
        
    </script>
@endpush
