@extends('user.layouts.app')
@section('title')
    @lang('Service')
@endsection

@section('styles')
    <style>
    </style>
@endsection

@section('content')

    <div class="container">
        <div class="card card-login mx-auto" style="border-radius: 15px">
            <div class="card-header"
                 style="padding: 1.25rem 1.25rem;border-radius: 15px;margin-bottom: 0;background-color: #fff;border-bottom: 1px solid #e9e9ef;">
                <h3 class="slogan text-dark" style="display: inline-block;margin-top: 5px;">@lang('Add Order')</h3>
                <div class="pull-left">
                    <a class="btn btn-info d-none backButton" href="{{route('user.service.show')}}">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </div>
                <div class="pull-left">
                    <a class="btn btn-info backButton search-button"  style="background: #1c84ee;padding: 12px 30px;" href="{{route('user.service.show')}}" >
                        <i class="fa fa-arrow-left"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="search-bar">
                    <div class="btn-group  mb-2" style="width:75%;">
                        <input type="text" class="form-control w-100" id="myInput" onkeyup="myFunction()">
                        <i id="clearsearch" class="fa fa-times-circle pull-left" onclick="clearSearch()"></i>
                    </div>
                    <button type="button" onclick="myFunction()" id="search" class="btn btn-primary mr-2 mb-2 search-button" style="background: #1c84ee;padding: 12px 30px;">@lang('Search')</button>
                </div>
                <form id="productForm" class="form" method="post" action="{{route('user.order.store')}}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-group products">
                        <div class="form-row">
                            <div class="w-100">
                                <ul class="products_list" id="myUL">
                                    @foreach($services as $key=>$service)
                                    <input type="hidden" value="pubg" id="operator">
                                    <li data-title=" {{$service->service_title }}" class="{{$service->is_available  != 1 ? 'disable ' : ''}} col-4 pr-0 pl-0" id="box{{$key+1}}"  onclick="{{$service->is_available}} == 1 ? as(this,'{{$key+1}}','9','{{$service->price}}','{{$service->id}}') : ''"
                                        style="width:32.3%; flex:1 1 25cm; list-style-type:none ; display:inline-block ; max-width:175px ; opacity: 1 ;">
                                        <div  class="product_group">
                                            <img
                                                src="{{ getFile(config('location.category.path').$service->category->image) }}"
                                                style="width: 100%;  height:auto; max-width:175px; opacity:1 ;">
                                            {{--                                            <div class="text1">--}}
                                            {{--                                                <p>UC PUBG 60</p>--}}
                                            {{--                                            </div>--}}
                                            <div class="service-title " style="font-weight:bold ;font-size: 13px;">
                                                <span class="">{{config('basic.currency_symbol')}} {{$service->price}} </span>
                                                <br><span class=""> ‎₺ {{$service->price * config('basic.exchange_rate')}}</span>
                                                <br>
                                                {{--                                                <span class="bx bxs-star text-warning"></span>--}}
                                                <span>{{$service->service_title}}</span>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <input type="hidden" name="service" id="product_id" class="form-control">
                        <div class="  mt-2">
                            <div class="ml-3 alert alert-info" id="bb" style="visibility:hidden ;">
                                <p id="desc">

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="qty">@lang('Quantity')</label>
                            <input name="quantity" value="1" class="form-control" id="qty" onchange="cal();"
                                   onkeyup="cal()" type="number" placeholder="أدخل الكمية">
                        </div>
                        <div class="col">
                            <label for="total">@lang('Total')</label>
                            <input name="total" value="" class="form-control" id="total" readonly="">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label>@lang('Player number') </label>
                            <input name="alt" value="" class="form-control" id="playerid" required="">
                        </div>
                    </div>
{{--                    <div class="  mt-2">--}}
{{--                        <div class="ml-3 alert alert-info">--}}
{{--                            هذا المنتج يعمل بشكل آلي على مدار الساعة--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <button class="btn btn-primary ml-3 mt-3 form_submit search-button" style="background: #1c84ee;padding: 12px 30px;">
                        <span class="indicator-label "></span>
                        @lang('Buy')
                        <div class="spinner-border indicator-progres d-none " role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>
                </form>
                <div class="row">
                    <div class="col-12 msg_html my-1">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function clearSearch(){
            document.getElementById('myInput').value = '';
            myFunction()
        }
        function myFunction() {
            // Declare variables

            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('myInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById("myUL");
            li = ul.getElementsByTagName('li');

            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("div")[0];

                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }

        function cal() {
            var price = sessionStorage.getItem('price')
            var qty = document.getElementById('qty').value;
            var totals = document.getElementById('total');
            totals.value = price * qty;
        }

        function as2(app, i, e, price, id) {
            //  $("#box"+i).append(`<i class="fa fa-check text-success"></i>`);
            console.log('1')
            document.getElementById('box' + i).style.opacity = "1";
            for (x = 1; x != i; x++) {
                document.getElementById('box' + x).style.opacity = "0.5";
            }
            for (x = e; x != i; x--) {
                document.getElementById('box' + x).style.opacity = "0.5";
            }
            var qty = document.getElementById('qty').value;
            var total = document.getElementById('total');
            total.value = price * qty;
            sessionStorage.setItem('price', price);

            var product = document.getElementById('product_id');
            product.value = id;

            var bb = document.getElementById('bb');
            bb.style.visibility = "visible";



        }

        function getName() {
            var refresh = document.getElementById('refresh');
            refresh.className = "fa fa-refresh fa-spin";

            var playerId = document.getElementById('playerid').value;
            var playerName = document.getElementById('playername');
            var operator = document.getElementById('operator').value;


            $.ajax({
                url: 'https://xp-card.com/customer/playerName',
                data: {
                    id: playerId,
                    operator: operator,
                    '_token': '0BYiYSEUBTACS4BUQBqJBam1tb1Ilvfc4iRLXWl4'
                },
                type: "POST",
                success: function(response) {
                    console.log(response);
                    playerName.value = response.playername;
                    refresh.className = "fa fa-refresh ";

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("المرجو التاكد من الرقم");
                }

            });

        }

        function as(app, i, e, price, id) {
            //  $("#box"+i).append(`<i class="fa fa-check text-success"></i>`);
            document.getElementById('box' + i).style.opacity = "1";
            document.getElementById('box' + i).style.transform  = "translateY(-50px)";
            document.getElementById('box' + i).style.transform  = "  scale(1.2)";
            for (x = 1; x != i; x++) {
                if (document.getElementById('box' + x)){
                    document.getElementById('box' + x).style.transform = "none";
                    document.getElementById('box' + x).style.opacity = "0.5";
                }

            }
            for (x = e; x != i; x--) {
                if (document.getElementById('box' + x)){
                    document.getElementById('box' + x).style.transform = "none";
                    document.getElementById('box' + x).style.opacity = "0.5";
                }
            }
            var qty = document.getElementById('qty').value;
            var total = document.getElementById('total');
            total.value = price * qty;
            sessionStorage.setItem('price', price);

            var product = document.getElementById('product_id');
            product.value = id;

            var bb = document.getElementById('bb');
            bb.style.visibility = "visible";

            var desc1 = document.getElementById('desc');

            // desc1.innerHTML =
        }
    </script>
@endpush
