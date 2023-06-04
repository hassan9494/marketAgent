@extends('admin.layouts.app')
@section('title')
    @lang('User Debts')
@endsection
@section('content')
        <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">

            <div class="card-body">

                <div class="table-responsive">
                    <table class="categories-show-table table table-hover table-striped table-bordered">
                        <thead class="thead-primary">
                        <tr>
                            <th scope="col" class="text-center">
                                <input type="checkbox" class="form-check-input check-all tic-check" name="check-all"
                                       id="check-all">
                                <label for="check-all"></label>
                            </th>
                            <th scope="col">@lang('Debt ID')</th>
                            <th scope="col">@lang('Debt')</th>
                            <th scope="col">@lang('User')</th>
                            <th scope="col">@lang('Debt AT')</th>
                            <th scope="col">@lang('Details')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($debts as $debt)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" id="chk-{{ $debt->id }}"
                                           class="form-check-input row-tic tic-check"
                                           name="check" value="{{ $debt->id }}" data-id="{{ $debt->id }}">
                                    <label for="chk-{{ $debt->id }}"></label>
                                </td>
                                <td data-label="@lang('Debt ID')"> {{$debt->id}} </td>
                                <td data-label="@lang('Debt')">
                                    <h5>{{$debt->debt}} @lang(config('basic.currency'))</h5>
                                </td>

                                <td data-label="@lang('User')">
                                    @lang($debt->user->username)
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
                    {{$debts->appends(@$_GET)->links()}}
                </div>
            </div>
            <div class="card-footer">
                <h2>@lang('Total') : {{$debts->where('is_paid' , 0)->sum('debt') - $debts->where('is_paid' , 1)->sum('debt')}}</h2>
            </div>
        </div>



    @endsection

    @push('js-lib')
        <script src="{{ asset('assets/global/js/jquery-ui.min.js') }}"></script>
    @endpush

    @push('js')

    @endpush
