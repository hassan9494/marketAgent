@extends('user.layouts.app')
@section('title')
    @lang('Service')
@endsection
@section('content')

     <div class="container" style="margin-bottom: 200px;">
        <div class="row">
            @foreach($categories as $key=>$category)
                <div class="column" >
                    <a href="{{route('user.services.show',$category->id)}}">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ getFile(config('location.category.path').$category->image) }}" alt="user">
                            </div>
                            <div class="card-footer">
                                <h4 class="text-dark">{{$category->category_title }}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@push('js')

@endpush
