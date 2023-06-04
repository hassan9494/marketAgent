@extends('user.layouts.app')
@section('title')
    @lang('Debt')
@endsection
@section('content')
     <div class="container-fluid px-3 user-service-list">

         <div class="row justify-content-between mx-lg-5">
             <div class="col-md-12">

                 <ol class="breadcrumb center-items">
                     <li><a href="{{route('user.home')}}">@lang('Home')</a></li>
                     <li class="active">@lang('Debt')</li>
                 </ol>

                <div class="card my-3">
                    <div class="card-body">
                        <form action="{{route('user.debt.search')}}" method="get">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="debt_id" value="{{@request()->debt_id}}" class="form-control get-trx-id"
                                               placeholder="@lang('Search for Debt ID')">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="is_paid" class="form-control get-service">
                                            <option value="-1"
                                                    @if(@request()->is_paid == '-1') selected @endif>@lang('All Debt')</option>
                                            <option value="0"
                                                    @if(@request()->is_paid == 0) selected @endif>@lang('Debt')</option>
                                            <option value="1"
                                                    @if(@request()->is_paid == 1) selected @endif>@lang('Debt Payment')</option>

                                        </select>
                                    </div>
                                </div>



                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="datetrx" id="datepicker"/>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn waves-effect waves-light w-100 btn-primary"><i class="fas fa-search"></i> @lang('Search')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
             </div>
         </div>


        <div class="row my-3 justify-content-between mx-lg-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body ">

                            <div class="table-responsive">
                            <table class="table  table-striped " id="service-table">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('Debt ID')</th>
                                    <th scope="col">@lang('Debt')</th>
                                    <th scope="col">@lang('Debt AT')</th>
                                    <th scope="col">@lang('Details')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($debts as $debt)
                                    <tr>
                                        <td data-label="@lang('Debt ID')"> {{$debt->id}} </td>
                                        <td data-label="@lang('Debt')">
                                            <h5>{{$debt->debt}} @lang(config('basic.currency'))</h5>
                                        </td>

                                        <td data-label="@lang('Debt AT')">
                                            @lang(dateTime($debt->created_at, 'd/m/Y - h:i A' ))
                                        </td>


                                        <td data-label="@lang('Details')">
                                <span
                                    class="badge badge-pill {{ $debt->is_paid == 0 ? 'badge-danger' : 'badge-success' }}">{{ $debt->is_paid == 0 ? 'دين' : 'دفعة دين' }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            </div>
                            {{ $debts->appends($_GET)->links() }}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('extra-script')
@endpush
