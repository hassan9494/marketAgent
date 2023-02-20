@extends('admin.layouts.app')
@section('title')
    @lang('Service Show')
@endsection
@push('style')
    <style>
        .custom-switch-checkbox-inner:after {
            content: "No"!important;
        }

        .custom-switch-checkbox-inner:before {
            content: "Yes"!important;
        }

        .modal-header .close{
            margin: -1rem -1rem!important;
        }
    </style>
@endpush
@section('content')

    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row ">
            <div class="col-xl-7">
                <form action="{{ route('admin.service-search') }}" method="get">
                    <div class="row">
                        <div class="col-md-4 col-xl-3">
                            <div class="form-group">
                                <input type="text" name="service" value="{{@request()->service}}" class="form-control"
                                       placeholder="@lang('Type Here')">
                            </div>
                        </div>

                        <div class="col-md-4 col-xl-3">
                            <div class="form-group">
                                <select name="category" id="category" class="form-control statusfield">
                                    <option value="-1"
                                            @if(@request()->category == '-1') selected @endif>@lang('All Category')</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}"
                                                @if(@request()->category == $category->id) selected @endif>@lang($category->category_title)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-xl-3">
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="-1"
                                            @if(@request()->status == '-1') selected @endif>@lang('All Status')</option>
                                    <option value="1"
                                            @if(@request()->status == '1') selected @endif>@lang('Active')</option>
                                    <option value="0"
                                            @if(@request()->status == '0') selected @endif>@lang('Inactive')</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-4 col-xl-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary w-100 w-sm-auto"><i
                                        class="fas fa-search"></i> @lang('Search')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-3">
                <button class="btn btn-success w-100 " type="button" data-toggle="modal"
                        data-target="#balance_refresh">
                    @lang('Get Syrian Market Price')
                    <span class="btn-label"><i class="fa fa-refresh" aria-hidden="true"></i></span>

                </button>
            </div>
            <div class="col-xl-2">
                <button class="btn btn-success w-100" type="button" data-toggle="modal"
                        data-target="#balance">@lang('Update Price')
                    <span class="btn-label"><i class="fa fa-plus" aria-hidden="true"></i></span>

                </button>
            </div>
        </div>
    </div>

    <div id="accordion" class="accordion-service">
        @foreach($categories as $key =>  $category)
            <div class="card card-primary m-0 m-md-4 my-1 m-md-0 ">
                <div class="card-header" id="faqhead{{$category->id}}">
                    <a href="#" class="btn btn-header-link" data-toggle="collapse"
                       data-target="#faq{{$category->id}}" aria-expanded="true"
                       aria-controls="faq{{$category->id}}">
                        {{$category->category_title }}
                    </a>
                </div>

                <div id="faq{{$category->id}}" class="collapse @if($loop->first) show @endif"
                     aria-labelledby="faqhead{{$category->id}}" data-parent="#accordion">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="categories-show-table table table-hover  table-striped table-bordered  text-right text-lg-center">
                                <thead class="thead-primary">
                                <tr>
                                    <th scope="col">
                                        <input type="checkbox"
                                               class="form-check-input check-all tic-check check-all-tic"
                                               id="cat-tic-{{ $key}}"
                                               name="check-all">
                                        <label for="cat-tic-{{ $key }}"></label>
                                    </th>

                                    <th scope="col">@lang('ID')</th>
                                    <th scope="col" class="text-left">@lang('Name')</th>
                                    <th scope="col">@lang('Selling Price')</th>
                                    <th scope="col">@lang('Capital Price')</th>
                                    <th scope="col">@lang('Status')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($category->service as $service)

                                    <tr>
                                        <td class="text-center check-box-width-50">
                                            <input type="checkbox"
                                                   class="form-check-input row-tic tic-check row-tic-check"
                                                   id="service-tic-{{ $service->id }}"
                                                   name="check" value="{{ $service->id }}" data-id="{{ $service->id }}">
                                            <label for="service-tic-{{ $service->id }}"></label>
                                        </td>

                                        <td data-label="@lang('ID')">@lang($service->id)</td>

                                        <td data-label="@lang('Name')" class="text-right text-lg-left">
                                            <a href="javascript:void(0)" data-container="body" data-toggle="popover"
                                               data-placement="top" data-content="{{$service->service_title}}">
                                                {{\Str::limit($service->service_title, 30)}}
                                            </a>
                                        </td>
                                        <td data-label="@lang('Selling Price')">
                                            {{ $service->price }} {{config('basic.currency_symbol')}}
                                        </td>
                                        <td data-label="@lang('Capital Price')">
                                            {{ $service->server_price }} {{config('basic.currency_symbol')}}
                                        </td>
                                        <td data-label="@lang('Status')">
                                            <span
                                                class="badge badge-pill {{ $service->service_status == 0 ? 'badge-danger' : 'badge-success' }}">{{ $service->service_status == 0 ? 'Inactive' : 'Active' }}</span>
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <a href="{{route('admin.service.edit',['id'=>$service->id])}}"
                                               class="btn btn-primary btn-rounded btn-sm" title="@lang('Edit')">
                                                <i class="fa fa-edit"
                                                   aria-hidden="true"></i>
                                            </a>

                                            @if($service->service_status == 0)
                                                <a href="javascript:void(0)"
                                                   class="btn btn-success btn-rounded btn-sm status-change"
                                                   data-toggle="modal"
                                                   data-target="#statusMoldal"
                                                   data-route="{{route('admin.service.status.change',['id'=>$service->id])}}">
                                                    <i class="fa fa-check-circle  "
                                                       aria-hidden="true"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0)"
                                                   class="btn btn-danger btn-rounded btn-sm status-change"
                                                   data-toggle="modal"
                                                   data-target="#statusMoldal"
                                                   data-route="{{route('admin.service.status.change',['id'=>$service->id])}}">
                                                    <i class="fa fa-times-circle  "
                                                       aria-hidden="true"></i>
                                                </a>

                                            @endif

                                            <button type="button" class="btn btn-secondary btn-rounded btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#description" id="details"
                                                    data-toggle="tooltip" title="@lang('Details')"
                                                    data-servicetitle="{{$service->service_title}}"
                                                    data-description="{{$service->description}}"
                                                    data-rateper="{{$service->api_provider_price}}"
                                                    data-orderlimit="{{$service->min_amount .' - ' .$service->max_amount}}">
                                                <i class="fa fa-info-circle"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($categories->total() > config('basic.paginate'))
        <div class="card card-primary m-0 m-md-4 my-4 m-md-0">
            <div class="card-body">
                {{ $categories->links() }}
            </div>
        </div>
    @endif

    <div class="modal fade" id="statusMoldal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Confirm Status Change')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" id="statusForm">
                    @csrf
                    <div class="modal-body">
                        <h2><i class="fas fa-sync-alt position-absolute"></i></h2>
                        <div class="body-centent pl-5">
                            <p>@lang('Are you want to change the current status')</p>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span>
                        </button>
                        <button type="submit" class="btn btn-primary"><span>@lang('Yes')</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="description">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p id="servicedescription"></p>
                    <p><strong>{{trans('Rate Per 1k')}} :</strong> <span
                            id="rateper"></span> {{config('basic.currency')}} </p>
                    <p><strong>{{trans('Order Limit')}} :</strong> <span id="orderlimit"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="all_active" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="title">@lang('Active Confirmation')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <h2><i class="fas fa-sync-alt position-absolute"></i></h2>
                    <div class="body-centent pl-5">
                        <p>@lang('Are you really want to active the category')</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">@lang('No')
                    </button>
                    <form action="" method="post">
                        @csrf
                        <a href="" class="btn btn-primary active-yes"><span>@lang('Yes')</span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="all_deactive" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="title">@lang('Inactive Confirmation')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <h2><i class="fas fa-sync-alt position-absolute"></i></h2>
                    <div class="body-centent pl-5">
                        <p>@lang('Are you really want to Inactive the category')</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span></button>
                    <form action="" method="post">
                        @csrf
                        <a href="" class="btn btn-primary deactive-yes"><span>@lang('Yes')</span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="balance">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" action="{{ route('admin.update_price') }}"
                      enctype="multipart/form-data">
                @csrf
                <!-- Modal Header -->
                    <div class="modal-header modal-colored-header bg-primary">
                        <h4 class="modal-title">@lang('Update Price')</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group ">
                            <p>@lang('Are you really want to chnage the price of All Services?')</p>
                            <label>@lang('Select Percentage Increase')</label>
                            <select class="form-control" name="Percentage">
                                @for($i = 1 ; $i <= 100 ;$i++)
                                    <option value="{{$i}}">
                                        {{$i}} %
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Do you want to update the current selling price?')</label>
                            <div class="custom-switch-btn w-md-100">
                                <input type='hidden' value='1' name='selling'>
                                <input type="checkbox" name="selling" class="custom-switch-checkbox" id="selling"
                                       value="0">
                                <label class="custom-switch-checkbox-label" for="selling">
                                    <span class="modal_status custom-switch-checkbox-inner"></span>
                                    <span class="custom-switch-checkbox-switch"></span>
                                </label>
                            </div>
                        </div>

                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('Close')</span>
                        </button>
                        <button type="submit" class=" btn btn-primary balanceSave"><span>@lang('Submit')</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="balance_refresh">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title">@lang('Price Refresh')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group ">
                        <p>@lang('Are you really want to refresh the price of All Services From Syrian Market?')</p>

                        <p>@lang('You will lose all previous price updates')</p>
                    </div>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('Close')</span>
                    </button>
                    <a href="{{route('admin.price_refresh')}}"
                       class=" btn btn-primary balanceSave"><span>@lang('Submit')</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('js')
    <script>

        $(document).ready(function () {
            "use strict";
            $(document).on('click', '.check-all-tic', function () {
                $(this).closest('table').find('input:checkbox').prop('checked', this.checked);
            });

            $(document).on('click', '.row-tic-check', function () {
                if ($(this).closest('table').find('.row-tic-check').length == $(this).closest('table').find('.row-tic-check:checked').length) {
                    $(this).closest('table').find('.check-all-tic').prop('checked', this.checked);
                } else {
                    $(this).closest('table').find('.check-all-tic').prop('checked', false);
                }
            });

            $(document).on('click', '.status-change', function () {
                let route = $(this).data('route');
                $('#statusForm').attr('action', route);
            });

            //modal show
            $(document).on('click', '#details', function () {
                var title = $(this).data('servicetitle');
                var description = $(this).data('description');
                var rateper = $(this).data('rateper');
                var orderlimit = $(this).data('orderlimit');
                $('#title').text(title);
                $('#servicedescription').text(description);
                $('#rateper').text(rateper);
                $('#orderlimit').text(orderlimit);
            });

            //dropdown menu is not working
            $(document).on('click', '.dropdown-menu', function (e) {
                e.stopPropagation();
            });


            //multiple active
            $(document).on('click', '.active-yes', function (e) {
                e.preventDefault();
                var allVals = [];
                $(".row-tic:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });
                if (allVals.length > 0) {
                    var strIds = allVals.join(",");
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        url: "{{ route('admin.service-multiple-active') }}",
                        data: {strIds: strIds},
                        datatType: 'json',
                        type: "get",
                        success: function (data) {
                            if (data.success == 1) {
                                location.reload();
                            }
                        }
                    });
                } else {
                    var strIds = allVals.join(",");
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        url: "{{ route('admin.service-multiple-active') }}",
                        data: {strIds: strIds},
                        datatType: 'json',
                        type: "get",
                        success: function (data) {
                            if (data.error == 1) {
                                location.reload();
                            }
                        }
                    });
                }
            });
            //multiple deactive
            $(document).on('click', '.deactive-yes', function (e) {
                e.preventDefault();
                var allVals = [];
                $(".row-tic:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });

                if (allVals.length > 0) {
                    var strIds = allVals.join(",");
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        url: "{{ route('admin.service-multiple-deactive') }}",
                        data: {strIds: strIds},
                        datatType: 'json',
                        type: "get",
                        success: function (data) {
                            if (data.success == 1) {
                                location.reload();
                            }
                        }
                    });
                } else {
                    var strIds = allVals.join(",");
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        url: "{{ route('admin.service-multiple-deactive') }}",
                        data: {strIds: strIds},
                        datatType: 'json',
                        type: "get",
                        success: function (data) {
                            if (data.error == 1) {
                                location.reload();
                            }
                        }
                    });
                }
            });

            //multiple delete
            $(document).on('click', '.delete-yes', function (e) {
                e.preventDefault();
                var allVals = [];
                $(".row-tic:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });
                if (allVals.length > 0) {
                    var strIds = allVals.join(",");
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        url: "{{ route('admin.service-multiple-delete') }}",
                        data: {strIds: strIds},
                        datatType: 'json',
                        type: "get",
                        success: function (data) {
                            if (data.success == 1) {
                                location.reload();
                            }
                        }
                    });
                } else {
                    var strIds = allVals.join(",");
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        url: "{{ route('admin.service-multiple-delete') }}",
                        data: {strIds: strIds},
                        datatType: 'json',
                        type: "get",
                        success: function (data) {
                            if (data.error == 1) {
                                location.reload();
                            }
                        }
                    });
                }
            });


            $('#category').select2({
                selectOnClose: true
            });

            $('#provider').select2({
                selectOnClose: true
            });

            $('select[name=status]').select2({
                selectOnClose: true
            });

        });
    </script>
@endpush

