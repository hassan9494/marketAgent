<!DOCTYPE html>
<html lang="en" @if(session()->get('rtl') == 1) dir="rtl" @endif >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/uploads/logo/favicon.png')}}">
    <title>@lang($basic->site_title) | @yield('title')</title>
    @stack('style-lib')
    <link href="{{asset('assets/admin/css/all.min.css')}}" rel="stylesheet">

    @if(session()->get('rtl') == 1)
        <link href="{{asset('assets/admin/css/theme_ar.css')}}" rel="stylesheet">
    @else
        <link href="{{asset('assets/admin/css/theme.css')}}" rel="stylesheet">
    @endif

    @if(session()->get('rtl') == 1)
        <link href="{{asset('assets/admin/css/style_ar.css')}}" rel="stylesheet">
    @else
        <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">
    @endif

    <link href="{{asset('assets/admin/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/custom.css')}}" rel="stylesheet">
    @stack('style')
</head>
<body>
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>

<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-7 align-self-center">
                    <h4 class="page-title text-truncate text-dark font-weight-medium mb-1 text-capitalize">@yield('title')</h4>

                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 p-0">
                                <li class="breadcrumb-item text-muted active"
                                    aria-current="page">@lang('Dashboard')</li>
                                <li class="breadcrumb-item text-muted text-capitalize"
                                    aria-current="page">@yield('title')</li>
                            </ol>
                        </nav>
                    </div>

                </div>

            </div>
        </div>
        @yield('content')

        <footer class="footer text-center text-muted">
            <p>تم التطوير من قبل شركة كودا . {{trans('All Rights Reserved')}}
                <a href="https://wa.me/+31685364242" target="_blank"><i class="fab fa-whatsapp" style="color: #0cc243;font-size: 20px;"></i></a>
                <a href="mailto:aaaaahm.sy@gmail.com" target="_blank"><i class="fa fa-envelope" style="color: #1a73e8;font-size: 20px;"></i></a>
            </p>
        </footer>
    </div>
</div>


<script src="{{asset('assets/global/js/jquery.min.js') }}"></script>
<script src="{{asset('assets/global/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/global/js/bootstrap.min.js') }}"></script>
@stack('js-lib')
<script src="{{ asset('assets/admin/js/app-style-switcher.js') }}"></script>
<script src="{{ asset('assets/admin/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/global/js/notiflix-aio-2.7.0.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/sidebarmenu.js')}}"></script>
<script src="{{ asset('assets/global/js/select2.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/admin-mart.js')}}"></script>
<script src="{{ asset('assets/admin/js/custom.js')}}"></script>

@include('admin.layouts.notification')
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
@stack('js')
@stack('extra-script')

<script>
    'use strict';


    let pushNotificationArea = new Vue({
        el: "#pushNotificationArea",
        data: {
            items: [],
        },
        mounted() {
            this.getNotifications();
            this.pushNewItem();
        },
        methods: {
            getNotifications() {
                let app = this;
                axios.get("{{ route('admin.push.notification.show') }}")
                    .then(function (res) {
                        app.items = res.data;
                    })
            },
            readAt(id, link) {
                let app = this;
                let url = "{{ route('admin.push.notification.readAt', 0) }}";
                url = url.replace(/.$/, id);
                axios.get(url)
                    .then(function (res) {
                        if (res.status) {
                            app.getNotifications();
                            if (link != '#') {
                                window.location.href = link
                            }
                        }
                    })
            },
            readAll() {
                let app = this;
                let url = "{{ route('admin.push.notification.readAll') }}";
                axios.get(url)
                    .then(function (res) {
                        if (res.status) {
                            app.items = [];
                        }
                    })
            },
            pushNewItem() {
                let app = this;
                // Pusher.logToConsole = true;
                let pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                    encrypted: true,
                    cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
                });
                let channel = pusher.subscribe('admin-notification.' + "{{ Auth::guard('admin')->id() }}");
                channel.bind('App\\Events\\AdminNotification', function (data) {
                    app.items.unshift(data.message);
                    const audio = new Audio('https://assets.mixkit.co/sfx/preview/mixkit-bell-notification-933.mp3');
                    audio.play();
                    if (Platform.OS === 'android') {
                        Notifications.createChannelAndroidAsync('notification-sound-channel', {
                            name: 'Notification Sound Channel',
                            sound: true,
                            priority: 'max',
                            vibrate: [0, 250, 250, 250],
                        });
                    }
                });
                channel.bind('App\\Events\\UpdateAdminNotification', function (data) {
                    app.getNotifications();
                    const audio = new Audio('https://assets.mixkit.co/sfx/preview/mixkit-bell-notification-933.mp3');
                    audio.play();
                    if (Platform.OS === 'android') {
                        Notifications.createChannelAndroidAsync('notification-sound-channel', {
                            name: 'Notification Sound Channel',
                            sound: true,
                            priority: 'max',
                            vibrate: [0, 250, 250, 250],
                        });
                    }
                });
            }
        }
    });
</script>
</body>
</html>
