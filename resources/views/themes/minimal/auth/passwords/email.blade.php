@extends($theme.'layouts.auth')
@section('title','Reset Password')


@section('content')

    <div class="auth-wrapper">
        <div class="auth-content">
            <div class="auth-bg">
                <span class="r"></span>
                <span class="r s"></span>
                <span class="r s"></span>
                <span class="r"></span>
            </div>
            <form method="POST" action="{{ route('password.email') }}" class="form-content w-100">
                @csrf
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i class="feather icon-unlock auth-icon"></i>
                        </div>
                        <h3 class="mb-4">@lang('Reset Password')</h3>
                        <div class="input-group mb-3">
                            <input class="form-control" type="email" name="email" value="{{old('email')}}"
                                   placeholder="@lang('Enter your Email Address')">
                            @error('email')
                            <p class="text-danger  mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button class="btn btn-primary shadow-2 mb-4" type="submit">@lang('Send Password Reset Link')</button>
                        <p class="mb-0 text-muted"><a
                                href="{{ route('register') }}">Signup</a> @lang('Don’t have an account?') </p>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

