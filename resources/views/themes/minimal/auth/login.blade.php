@extends($theme.'layouts.auth')
@section('title','Login')
@section('content')
<div class="auth-wrapper">
    <div class="auth-content">
        <div class="auth-bg">
            <span class="r"></span>
            <span class="r s"></span>
            <span class="r s"></span>
            <span class="r"></span>
        </div>
        <form method="POST" action="{{ route('login') }}" class="form-content w-100">
            @csrf
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="feather icon-unlock auth-icon"></i>
                    </div>
                    <h3 class="mb-4">@lang('Login')</h3>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" name="username" value="{{old('username')}}"
                               placeholder="@lang('Email Or Username')">
                    </div>
                        @error('username')<p class="text-danger  mt-1">{{ $message }}</p>@enderror
                        @error('email')<p class="text-danger  mt-1">{{ $message }}</p>@enderror

                    <div class="input-group mb-4">
                        <input class="form-control " type="password" name="password"
                               placeholder="@lang('Password')">
                    </div>
                        @error('password')
                        <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror

                    <div class="form-group text-right">
                        <div class="checkbox checkbox-fill d-inline">
                            <input type="checkbox" name="remember" id="remember"  {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="cr"> @lang('Remember me')</label>
                        </div>
                    </div>
                    <button class="btn btn-primary shadow-2 mb-4" type="submit">@lang('Login')</button>
                    <p class="mb-2 text-muted"> <a href="{{ route('password.request') }}"> Reset </a> @lang('Forgot password? ')</p>
                    <p class="mb-0 text-muted"><a href="{{ route('register') }}">Signup</a> @lang('Don’t have an account?') </p>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection
@push('script')
@endpush
