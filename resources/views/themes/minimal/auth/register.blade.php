@extends($theme.'layouts.auth')
@section('title','REGISTER')
@section('content')
    <div class="auth-wrapper">
        <div class="auth-content register">
            <div class="auth-bg">
                <span class="r"></span>
                <span class="r s"></span>
                <span class="r s"></span>
                <span class="r"></span>
            </div>
            <form method="POST" action="{{ route('register') }}" class="form-content w-100">
                @csrf
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i class="feather icon-unlock auth-icon"></i>
                        </div>
                        <h3 class="mb-4">@lang('REGISTER')</h3>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <input class="form-control " type="text" name="firstname"
                                           value="{{old('firstname')}}" placeholder="@lang('First Name')">
                                    @error('firstname')
                                    <p class="text-danger  mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <input class="form-control " type="text" name="lastname" value="{{old('lastname')}}"
                                           placeholder="@lang('Last Name')">
                                    @error('lastname')
                                    <p class="text-danger  mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <input class="form-control " type="text" name="username"
                                           value="{{old('username')}}" placeholder="@lang('Username')">
                                    @error('username')
                                    <p class="text-danger  mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <input class="form-control" type="text" name="email"
                                           value="{{old('email')}}"
                                           placeholder="@lang('Email Address')">
                                    @error('email')
                                    <p class="text-danger  mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <div class="input-group ">
                                            <select name="phone_code" class="form-control country_code">
                                                @foreach($countries as $value)
                                                    <option value="{{$value['phone_code']}}"
                                                            data-name="{{$value['name']}}"
                                                            data-code="{{$value['code']}}"
                                                        {{$country_code == $value['code'] ? 'selected' : ''}}
                                                    > {{$value['phone_code']}} <strong>({{$value['name']}})</strong>
                                                    </option>
                                                @endforeach
                                            </select>

                                    </div>


                                </div>
                            </div>
                            <div class="col-6">
                                <div class="">
                                    <input type="text" name="phone" class="form-control pl-3"
                                           value="{{old('phone')}}"
                                           placeholder="Your Phone Number">
                                    @error('phone')
                                    <p class="text-danger  mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-4">
                                    <input class="form-control " type="password"
                                           name="password"
                                           placeholder="@lang('Password')">
                                    @error('password')
                                    <p class="text-danger mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-4">
                                    <input class="form-control " type="password" name="password_confirmation"
                                           placeholder="@lang('Confirm Password')">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary shadow-2 mb-4" type="submit">@lang('Register')</button>
                        <p class="mb-0 text-muted"><a
                                href="{{ route('login') }}">@lang('Login')</a> @lang("Already have account?") </p>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('script')
@endpush
