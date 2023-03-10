@extends('admin.layouts.app')
@section('title')
    @lang('Edit Service')
@endsection
@section('content')
    <div class="card card-primary card-form m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body ">
            {{--@dd($errors)--}}
            <form action="{{ route('admin.service.update') }} " method="POST" class="form">
                @csrf
                <h5 class="table-group-title text-info mb-2 mb-md-3"><span>@lang('Service Basic')</span></h5>
                <input type="hidden" name="id" value="{{$service->id}}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>@lang('Service Title')</label>
                            <input type="text" name="service_title"
                                   value="{{old('service_title',$service->service_title)}}"
                                   class="form-control form-control-sm">
                            @if($errors->has('service_title'))
                                <div class="error text-danger">@lang($errors->first('service_title')) </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Select Category')</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="{{old('category_id',$service->category_id)}}" selected
                                        hidden>@lang('Change Category')</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id  }}"
                                            @if($service->category_id == $category->id ) selected @endif>{{ $category->category_title  }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category_id'))
                                <div class="error text-danger">@lang($errors->first('category_id')) </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
                <h5 class="table-group-title text-primary mb-2 mb-md-3"><span>@lang('Price & Status')</span></h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Minimum Amount')</label>
                            <input type="number" class="form-control square" name="min_amount"
                                   value="{{old('min_amount',$service->min_amount)}}">
                            @if($errors->has('min_amount'))
                                <div class="error text-danger">@lang($errors->first('min_amount')) </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>@lang('Selling Price') </label>
                            <input type="text" class="form-control square" name="price" placeholder="50.25"
                                   value="{{old('price',$service->price)}}">
                            @if($errors->has('price'))
                                <div class="error text-danger">@lang($errors->first('price')) </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group ">
                                    <label class="d-block">@lang('Status') </label>
                                    <div class="custom-switch-btn">
                                        <input type='hidden' value='1' name='service_status'>
                                        <input type="checkbox" name="service_status" class="custom-switch-checkbox"
                                               id="service_status"
                                               value="0" {{ $service->service_status == '0' ? 'checked': '' }} >
                                        <label class="custom-switch-checkbox-label" for="service_status">
                                            <span class="custom-switch-checkbox-inner"></span>
                                            <span class="custom-switch-checkbox-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group ">
                                    <label class="d-block">@lang('Available')</label>
                                    <div class="custom-switch-btn">
                                        <input type='hidden' value='1' name='is_available'>
                                        <input type="checkbox" name="is_available" class="custom-switch-checkbox"
                                               id="is_available" value="0" {{ $service->is_available == 0 ? 'checked': '' }} >
                                        <label class="custom-switch-checkbox-label" for="is_available">
                                            <span class="custom-switch-checkbox-inner"></span>
                                            <span class="custom-switch-checkbox-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Maximum Amount')</label>
                            <input type="number" class="form-control square" name="max_amount"
                                   value="{{old('max_amount',$service->max_amount)}}">
                            @if($errors->has('max_amount'))
                                <div class="error text-danger">@lang($errors->first('max_amount')) </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>@lang('Capital Price') </label>
                            <input readonly type="text" class="form-control square"
                                   value="{{old('price',$service->server_price)}}">
                        </div>

                    </div>

                </div>
                <div class="divider"></div>
                <div class="form-group">
                    <label class="control-label " for="description">@lang('Description')</label>
                    <textarea class="form-control" rows="8"
                              name="description">{{ old('description', $service->description) }}</textarea>

                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3"><span><i
                                class="fas fa-save pr-2"></i> @lang('Save Changes')</span>
                </button>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        "use strict";
        $(document).ready(function (e) {
            $(document).on('click', '#more', function () {
                $(".moreField").removeClass('d-none');
            });
            $(document).on('click', '#less', function () {
                $(".moreField").addClass('d-none');
            });

            $('#category_id').select2({
                selectOnClose: true
            });
        });
    </script>
@endpush
