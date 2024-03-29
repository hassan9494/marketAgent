@extends('user.layouts.app')
@section('title')
    @lang('Service')
@endsection

@section('styles')
    <style>
    </style>
@endsection

@section('content')
    {{--    <div class="container" style="margin-bottom: 200px;">--}}
    {{--        <div class="row">--}}
    {{--            @foreach($services as $service)--}}
    {{--                <div class="column">--}}
    {{--                        <div class="card">--}}
    {{--                            <div class="card-header" style="padding: 0px;">--}}
    {{--                                <img src="{{ getFile(config('location.category.path').$service->category->image) }}" alt="user" style="width: 100%">--}}
    {{--                            </div>--}}
    {{--                            <div class="card-body">--}}
    {{--                                <h4 class="text-dark">{{$service->service_title }}</h4>--}}
    {{--                            </div>--}}
    {{--                            <div class="card-footer">--}}
    {{--                                <div class="price" data-price=" 2.69 $">--}}
    {{--                                    <span> {{$service->price }} @lang(config('basic.currency_symbol'))</span>--}}
    {{--                                    <span>|</span>--}}
    {{--                                    <span>{{$service->price * 10 }} @lang(config('basic.currency_symbol'))</span>--}}
    {{--                                </div>--}}
    {{--                                <h4 class="text-dark">{{$service->price }} @lang(config('basic.currency_symbol'))</h4>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}

    {{--                </div>--}}
    {{--            @endforeach--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <div class="container-fluid">
        <div class="contain-cards-order services">
            <h3 class="text-dark">@lang('Add Order') <a href="{{ route('user.service.show') }}"><i
                        class="fa fa-arrow-right"></i></a></h3>
            <div class="search">
                <input type="text" class="myInput" placeholder="">
                <button class="btn search-button">@lang('Search')</button>
            </div>
            <div class="cards-order" id="cards-services">
                @foreach($services as $service)
                    <div class="item it {{$service->service_status == 0 ? 'disable' : ''}}" data-title=" {{$service->service_title }}">
                        {{--                    <div class="image">--}}
                        {{--                        <img src="{{ getFile(config('location.category.path').$service->category->image) }}" alt="user" style="width: 100%">--}}
                        {{--                    </div>--}}
                        <div class="name" data-id="{{$service->id }}" data-name="{{$service->service_title }}">
                            {{$service->service_title }}
                            <div class="icon">
                                <img src="{{asset($themeTrue.'imgs/tumile.png')}}" alt="user">
                            </div>
                        </div>
                        <div class="price" data-price=" {{$service->price}} {{config('basic.currency_symbol')}}">
                            <span>  {{$service->price}} {{config('basic.currency_symbol')}}</span>
                            <span>‎₺{{$service->price * config('basic.exchange_rate')}}</span>
                        </div>


                        <div class="fire">
                            <img src="{{asset($themeTrue.'imgs/firegif_2.gif')}}" alt="user">
                        </div>
                    </div>

                    {{--<div class="item disable">--}}
                    {{--<div class="pack">--}}
                    {{--‏tumile 1250 coins--}}
                    {{--<div class="icon">--}}
                    {{--<img src="{{asset($themeTrue.'imgs/tumile.png')}}" alt="user">--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="name">--}}
                    {{--$3.34--}}
                    {{--</div>--}}
                    {{--<div class="fire">--}}
                    {{--<img src="{{asset($themeTrue.'imgs/firegif_2.gif')}}" alt="user">--}}
                    {{--</div>--}}
                    {{--</div>--}}
                @endforeach
            </div>

            <form class="form" method="post" action="{{route('user.order.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12  mb-2">
                        <label for="">@lang('quantity')</label>
                        <input type="number" name="quantity" class="quantity" value="1">

                    </div>
                    <div class="col-12  mb-2">
                        <label for="">@lang('Total')</label>
                        <input type="text" name="total" class="total" readonly>
                    </div>
                    @if($category->type == "GAME")
                        <div class=" col-10  mb-2" >
                            <label for="player_number">@lang('Player number')</label>
                            <input type="text" name="link" id="player_number" placeholder="" required
                                   oninvalid="setCustomValidity('أدخل رقم اللاعب من فضلك ')"
                                   onchange="try{setCustomValidity('')}catch(e){}">
                            <div class="vald-player-number"></div>
                            <div class="vald-player-number">@lang('أدخل رقم اللاعب من فضلك')</div>
                        </div>
                        <div class="col-2 d-flex align-items-center refresh mb-2">
                            <!-- <i class="fas fa-sync-alt get-name"></i> -->
                            <i class="fas fa-crosshairs get-name "></i>
                        </div>
                        <div class="col-10 col-sm-12 mb-2 mt-3">
                            <label for="player_name">@lang('Player name')</label>
                            <input type="text" name="player_name" id="player_name">
                        </div>
                    @elseif($category->type == "BALANCE" || $category->type == "OTHER")
                        <div class="col-12 col-sm-10">
                            <label for="special_field">{{$category->special_field}}</label>
                            <input type="text" name="special_field"
                                   placeholder="@lang('add') {{$category->special_field}}">
                        </div>
                    @else
                        <input type="hidden" name="link" value="">
                    @endif
                    <div class="col-10 col-sm-12 mb-2 d-flex align-items-center">
                        <input type="checkbox" name="agree" class="agree" id="agree">
                        <label for="player_name">@lang('نعم قمت بتأكيد الطلب')</label>
                    </div>
                    <div class="col-12 mt-4 text-center ">
                        <div class="chosen-item">
                        <span>
    <img
        src="{{asset($themeTrue.'imgs/tumile.png')}}"
        alt="user"
    > x<span class="quantity-val"></span></span>
                            <span class="name-val"></span>
                            <span class="price-val"></span>
                        </div>
                    </div>
                    {{--                <div class="col-12 mt-4 text-center ">--}}
                    {{--                    <label for="special_field">@lang('Coupon')</label>--}}
                    {{--                    <input type="text" name="coupon"--}}
                    {{--                           placeholder="@lang('add Coupon')">--}}
                    {{--                </div>--}}
                    <input class="inp-hid-serv" type="text" name="service" value="{{$category->id}}" hidden>
                    <input class="inp-hid-catg" type="text" name="category" value="{{$category->id}}" hidden>
                    <div class="col-12 mt-4 text-center add">
                        <button type="" id="btn-add" class="btn disble" disabled>@lang('Add')</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

@endsection
@push('js')
    <script>
        "use strict";
        var itemSelected = false;
        // fun 1
        $(".get-name").on("click", function() {
            var category_id = $('.inp-hid-catg').val();
            var player_number = $('#player_number').val();
            if(player_number == ""){
                $('.vald-player-number').addClass('active');
            }
            else{
                $('#player_name').val('please wait');
                $(".get-name").addClass('fa-spinner active');
                $.ajax({
                    url:'/user/player/'+category_id+'/'+player_number,
                    type:"GET",
                    success:function(response){
                        console.log(response);
                        $('#player_name').val(response.username);
                        $(".get-name").removeClass('fa-spinner active');
                    },
                })
            }
        });
        // fun 2
        $("#player_number").on("keyup", function() {
            if(player_number != ""){
                $('.vald-player-number').removeClass('active');
            }
            else{
                $('.vald-player-number').addClass('active');
            }
        });
        // fun 3
        $(".myInput").on("keyup", function() {
            var value = this.value.toLowerCase().trim();
            $(".it").show().filter(function() {
                return $(this).attr("data-title").toLowerCase().trim().indexOf(value) == -1;
            }).hide();
        });

        $('#cards-services .item').on('click', function (event) {
            if($(this).hasClass("disable")){
                event.preventDefault();
            }
                // else if($(this).hasClass("active")){
                //     $(this).removeClass('active');
                //     $('.chosen-item').removeClass('active');
                //     $('#cards-services .item').removeClass('un-active');
                //     $(".total").val('0');
                //     $('.quantity').val('0');
                //     itemSelected = false;
                //     $('#btn-add').addClass('disble');
                //     $('#btn-add').attr("disabled","");
            // }
            else{
                $('#cards-services .item').removeClass('active');
                $('#cards-services .item').addClass('un-active');
                $(this).addClass('active');
                $('.chosen-item').addClass('active');
                var name =  $(this).children(`.name`).attr("data-name");
                var price =  $(this).children(`.price`).attr("data-price").replace('$','');
                // get & set id
                var id =  $(this).children(`.name`).attr("data-id");
                $('.inp-hid-serv').val(id);

                $(".name-val").html(name);
                $(".price-val").html(`${price}$`);
                if($('.quantity').val() > 1){
                    $(".total").val(` ${price * $('.quantity').val()} $`);

                }
                else{
                    $(".total").val(` ${price} $`);
                    $('.quantity').val('1');
                }
                // $('.quantity').val('1');
                $('.quantity-val').html('1');
                $(".quantity").keyup(function(){
                    var valu =  $(this).val();
                    $(".quantity-val").html(valu);
                    $(".total").val(`${valu*price}$`);
                    $(".price-val").html(`${valu*price}$`);
                });
                itemSelected = true;
                if($('.agree').is(':checked')){
                    $('#btn-add').removeClass('disble');
                    $('#btn-add').removeAttr("disabled");
                    $("#checklabel").html(`نعم قمت بتأكيد الطلب`);
                    $("#checklabel").css("color","#fff");
                }
            }

            event.preventDefault();
        });
        // fun 4
        $('.agree').on('click', function (event) {
            if(itemSelected ){
                if (!$('.agree').is(':checked')) {
                    $('#btn-add').addClass('disble');
                    $('#btn-add').attr("disabled","");
                }
                else{
                    $('#btn-add').removeClass('disble');
                    $('#btn-add').removeAttr("disabled");
                }
            }
            else{
                if(itemSelected == false){
                    $("#checklabel").html(`يجب عليك أختيار باقة`);
                    $("#checklabel").css("color","red");
                }
            }
        });
        // fun 5
        $('#btn-add').on('click', function (event) {
            setTimeout(function() {
                if(itemSelected && $("#player_number").val().length != 0 ){
                    $('#btn-add').addClass('disble');
                    $('#btn-add').attr("disabled","");
                }
            }, 10);
        });
        {{--"use strict";--}}
        {{--$(document).on('click', '#details', function () {--}}
        {{--var title = $(this).data('servicetitle');--}}
        {{--var id = $(this).data('id');--}}
        {{--var orderRoute = "{{route('user.order.create')}}" + '?serviceId=' + id;--}}
        {{--$('.order-now').attr('href', orderRoute);--}}
        {{--var description = $(this).data('description');--}}
        {{--$('#title').text(title);--}}
        {{--$('#servicedescription').text(description);--}}
        {{--});--}}
        // // Add active class to the current side-bar item
        // var cards = document.getElementById("cards");
        // var li = cards.getElementsByClassName("card-item");
        // var add = document.getElementById("add");
        //
        // add.addEventListener("click", function(event) {
        //     event.preventDefault();
        // });
        //
        // for (var i = 0; i < li.length; i++) {
        //     li[i].addEventListener("click", function() {
        //         add.classList.add('active');
        //         // ****************** set code here ******************
        //     });
        // }
    </script>
@endpush
