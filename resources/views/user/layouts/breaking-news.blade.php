<div class="" style="max-width: 100%">
{{--    <div class="row" style="background-color:#ce3279 !important ">--}}
        <div class="row">
            <div class="d-flex justify-content-between align-items-center breaking-news"
            style="
            width: 100%;
            background-image: linear-gradient(to right bottom,#1c81c2, #1c81c2, #0894cf, #05a2c7, #0ac9db);
            ">
                <div class="d-flex flex-row flex-grow-1 flex-fill justify-content-center bg-danger py-2 text-white px-1 news"
                     style="background-color: #ce3279!important;width: 200px">
                    <span class="d-flex align-items-center">&nbsp;@lang('WDM News')</span>
                </div>
                <marquee class="news-scroll" behavior="scroll" direction="left" onmouseover="this.stop();"
                         onmouseout="this.start();">
                    @foreach($notices as $notice)
                    <a href="#" style="color: white">{{$notice->title}} </a>
                    <img src="{{ getFile(config('location.logoIcon.path').'logo2.png')}}" width="25px"></img>
                    @endforeach
                </marquee>
            </div>
        </div>
{{--    </div>--}}
</div>
