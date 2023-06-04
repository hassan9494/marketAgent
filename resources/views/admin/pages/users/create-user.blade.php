@extends('admin.layouts.app')
@section('title')
    @lang('Add User')
@endsection
@push('style')
    <style>
        .custom-switch-checkbox-inner:after {
            content: "No"!important;
        }

        .custom-switch-checkbox-inner:before {
            content: "Yes"!important;
        }
    </style>
@endpush
@section('content')


    <div class="m-0 m-md-4 my-4 m-md-0">
        <div class="row">

            <div class="col-sm-12">
{{--                <div class="card ">--}}
{{--                    <div class="card-body">--}}

{{--                        <h4 class="card-title text-white">@lang('API Key')--}}
{{--                            <button type="button"--}}
{{--                                    class="btn btn-primary btn-sm  text-white float-right  waves-effect generateBtn"><i--}}
{{--                                    class="fa fa-spinner"></i> @lang('Generate Key')</button>--}}
{{--                        </h4>--}}

{{--                        <div class="form-group ">--}}
{{--                            <h6 class="font-weight-bold">@lang('API KEY')</h6>--}}
{{--                            <div class="input-group">--}}
{{--                                <input type="text" value=""--}}
{{--                                       class="form-control form-control-lg api-token" id="referralURL"--}}
{{--                                       readonly>--}}
{{--                                <div class="input-group-append">--}}
{{--                                    <span class="input-group-text copytext copyBoard" id="copyBoard">--}}
{{--                                            <i class="fa fa-copy"></i>--}}
{{--                                        </span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="card card-primary">
                    <div class="card-body">
{{--                        <h4 class="card-title">{{ ucfirst($user->username) }} @lang('Information')</h4>--}}
                        <form method="post" action="{{ route('admin.user.store') }}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group ">
                                        <label>@lang('First Name')</label>
                                        <input class="form-control" type="text" name="firstname" value="{{old('firstname')}}"
                                               required>
                                        @error('firstname')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group ">
                                        <label>@lang('Last Name')</label>
                                        <input class="form-control" type="text" name="lastname" value="{{old('lastname')}}"
                                               required>
                                        @error('lastname')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group ">
                                        <label>@lang('Username')</label>
                                        <input class="form-control" type="text" name="username"
                                               value="{{old('username')}}" required>
                                        @error('username')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group ">
                                        <label>@lang('Email')</label>
                                        <input class="form-control" type="email" name="email" value="{{old('email')}}"
                                               required>
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group ">
                                        <label>@lang('Phone Number')</label>
                                        <input class="form-control" type="text" name="phone" value="{{old('phone')}}">
                                        @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                @if(0 < count($languages))
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label>@lang('Preferred Language')</label>

                                            <select name="language_id" class="form-control">
                                                <option value="" disabled>@lang('Select Language')</option>
                                                @foreach($languages as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                @endif
                                <div class="col-sm-12">
                                    <div class="form-group ">
                                        <label>@lang('Address')</label>
                                        <textarea class="form-control" name="address"
                                                  rows="2">{{old('address')}}</textarea>
                                        @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group ">
                                                <label>@lang('Password')</label>
                                                <input id="new_password" type="password" class="form-control" name="password"
                                                       autocomplete="current-password">
                                                @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group ">
                                                <label>@lang('Confirm Password')</label>
                                                <input id="confirm_password" type="password" name="password_confirmation"
                                                       autocomplete="current-password" class="form-control">
                                                @error('password_confirmation')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="file" name="image" placeholder="@lang('Choose image')" id="image" class="d-none">

                            </div>
                            <div class="submit-btn-wrapper mt-md-3  text-center text-md-left">
                                <button type="submit"
                                        class=" btn waves-effect waves-light btn-rounded btn-primary btn-block">
                                    <span>@lang('Update User')</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>







@endsection
@push('js')
    <script>
        "use strict";
        $(document).ready(function () {
            $(document).on('click', '#image-label', function () {
                $('#image').trigger('click');
            });
            $(document).on('change', '#image', function () {
                var _this = $(this);
                var newimage = new FileReader();
                newimage.readAsDataURL(this.files[0]);
                newimage.onload = function (e) {
                    $('#image_preview_container').attr('src', e.target.result);
                }
            });
            $(document).on('click', '.balanceSave', function () {
                var bala = $('#balance').text();
            });
        });


        $('.copyBoard').on('click',function () {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            Notiflix.Notify.Success("Copied: " + copyText.value);
        });

        {{--$('.generateBtn').on('click', function () {--}}
        {{--    $.ajax({--}}
        {{--        url: "{{route('admin.user.keyGenerate',[$user->id])}}",--}}
        {{--        type: 'POST',--}}
        {{--        success(data) {--}}
        {{--            $("#referralURL").val(data)--}}

        {{--            Notiflix.Notify.Success("KEY GENERATE: " + data);--}}

        {{--        }--}}
        {{--    });--}}
        {{--});--}}

        $(document).on('click', '.loginAccount', function () {
            var route = $(this).data('route');
            $('.loginAccountAction').attr('action', route)
        });


    </script>
@endpush


