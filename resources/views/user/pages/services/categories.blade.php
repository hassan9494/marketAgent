@extends('user.layouts.app')
@section('title')
    @lang('Service')
@endsection
@section('content')

     <div class="container" style="margin-bottom: 200px;">
        <div class="row">
            @foreach($categories as $key=>$category)
                <div class="column">
                    <a href="{{route('user.services.show',$category->id)}}" >
                        <div class="product-card">
                            <div class="product-thumb">
                                <img  src="{{ getFile(config('location.category.path').$category->image) }}" alt="img">
{{--                                <a href="#" class="badge in-stock">In Stock</a>--}}
{{--                                <ul class="shop-action">--}}
{{--                                    <li><a href="#"><i class="lar la-heart"></i></a></li>--}}
{{--                                    <li><a href="#"><i class="las la-retweet"></i></a></li>--}}
{{--                                    <li><a href="#"><i class="las la-expand-arrows-alt"></i></a></li>--}}
{{--                                </ul>--}}
{{--                                <a href="cart.html" class="default-btn">Add To Cart<span></span></a>--}}
                            </div>
                            <div class="product-info">
{{--                                <div class="product-inner">--}}
{{--                                    <ul class="category">--}}
{{--                                        <li><a href="#">Mouse</a></li>--}}
{{--                                    </ul>--}}
{{--                                    <ul class="rating">--}}
{{--                                        <li><i class="las la-star"></i></li>--}}
{{--                                        <li><i class="las la-star"></i></li>--}}
{{--                                        <li><i class="las la-star"></i></li>--}}
{{--                                        <li><i class="las la-star"></i></li>--}}
{{--                                        <li><i class="las la-star"></i></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
                                <h3>{{$category->category_title }}</h3>
{{--                                <h4 class="price">$49.00</h4>--}}
                            </div>
                        </div>
{{--                        <div class="card">--}}
{{--                            <div class="card-body">--}}
{{--                                <img src="{{ getFile(config('location.category.path').$category->image) }}" alt="user">--}}
{{--                            </div>--}}
{{--                            <div class="card-footer">--}}
{{--                                <h4 class="text-white" style="font-size: 25px">{{$category->category_title }}</h4>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@push('js')

@endpush
