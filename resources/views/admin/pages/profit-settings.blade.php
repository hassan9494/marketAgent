@extends('admin.layouts.app')
@section('title')
    @lang('Profit Settings')
@endsection
@section('content')


    <div class="alert alert-warning my-5 m-0 m-md-4" role="alert">
        <i class="fas fa-info-circle mr-2"></i> @lang("You can modify these settings to control the process of changing the selling prices when adjusting the capital price in the Syrian Market.")
    </div>
    <div class="alert alert-warning my-5 m-0 m-md-4" role="alert">
        <i class="fas fa-info-circle mr-2"></i> @lang("If you enable the automatic price update, a profit percentage equal to the specified percentage profit rate will be added to the capital price automatically.")
    </div>
    <div class="alert alert-warning my-5 m-0 m-md-4" role="alert">
        <i class="fas fa-info-circle mr-2"></i> @lang("If you do not do it, only the capital price will be updated, and the status of the product will be changed to inactive until it is modified by you.")
    </div>
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0">
        <div class="card-body">
            <form method="post" action="" novalidate="novalidate"
                  class="needs-validation base-form">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">@lang('Profit Percentage')</label>
                        <input type="number" name="percentage_profit"
                               value="{{ old('percentage_profit') ?? $control->percentage_profit ?? 'Site Title' }}"
                               class="form-control ">

                        @error('percentage_profit')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                    <div class="form-group col-sm-6 ">
                        <label class="font-weight-bold">@lang('Automatic Price Refresh')</label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='automatic_price_refresh'>
                            <input type="checkbox" name="automatic_price_refresh" class="custom-switch-checkbox"
                                   id="automatic_price_refresh"
                                   value="0" <?php if ($control->automatic_price_refresh == 0):echo 'checked'; endif ?> >
                            <label class="custom-switch-checkbox-label" for="automatic_price_refresh">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>


                </div>
                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3"><span><i
                            class="fas fa-save pr-2"></i> @lang('Save Changes')</span></button>
            </form>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $(document).ready(function () {
            "use strict";
            $('select[name=time_zone]').select2({
                selectOnClose: true
            });
        });
    </script>
@endpush

