<!DOCTYPE html>
<html  lang="en" @if(session()->get('rtl') == 1) dir="rtl" @endif >
<head>
    @include('user.layouts.head')
</head>
<body  @if(session()->get('dark-mode') == 'true') class="dark-mode" @endif>
<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full" class="mini-sidebar ">

    @include('user.layouts.header')

{{--    @include('user.layouts.side-notify')--}}
        @include('user.layouts.breaking-news')
    <div class="page-wrapper d-block">
        @yield('content')
    </div>

    <footer class="footer text-center text-muted">
        <p>تم التطوير من قبل شركة كودا . {{trans('All Rights Reserved')}}
            <a href="https://wa.me/+31685364242" target="_blank"><i class="fab fa-whatsapp" style="color: #0cc243;font-size: 20px;"></i></a>
            <a href="mailto:aaaaahm.sy@gmail.com" target="_blank"><i class="fa fa-envelope" style="color: #1a73e8;font-size: 20px;"></i></a>
        </p>
    </footer>

    <button class="scroll-top2 scroll-to-target2 open2">
        <a href="https://wa.me/+905368620432" target="_blank"><i class="fab fa-whatsapp"></i></a>
    </button>

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



<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

@include('user.layouts.notification')
@stack('js')



<script>
    "use strict";
    if(!localStorage.sidenote || localStorage.sidenote == 'true'){
        $('.fixed-icon').removeClass('rfixedicon');
        $('.fixedsidebar').removeClass('rfixed');
    }

    $(document).on('click', '.close-sidebar',function () {
        $('.fixed-icon').addClass('rfixedicon');
        $('.fixedsidebar').addClass('rfixed');
        localStorage.setItem("sidenote", false);
    });

    $(document).on('click', '.fixed-icon', function () {

        $('.fixed-icon').toggleClass('rfixedicon');
        $('.fixedsidebar').toggleClass('rfixed');

        if (typeof(Storage) !== "undefined") {
            if(localStorage.sidenote == 'true'){
                localStorage.setItem("sidenote", false);
            }else{
                localStorage.setItem("sidenote", true);
            }
        }
    });

    document.querySelector('.burger-menu').addEventListener('click', function() {
        var headerMenu = document.querySelector('.header-menu-wrap');
        this.classList.toggle('open');
        headerMenu.classList.toggle('fade-in');
    });

    const darkMode = () => {
        var $theme =document.body.classList.toggle("dark-mode");

        $.ajax({
            url: "{{ route('themeMode') }}/"+$theme,
            type: 'get',
            success: function(response){
            }
        });
    };
</script>


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
                axios.get("{{ route('user.push.notification.show') }}")
                    .then(function (res) {
                        app.items = res.data;
                    })
            },
            readAt(id, link) {
                let app = this;
                let url = "{{ route('user.push.notification.readAt', 0) }}";
                url = url.replace(/.$/, id);
                axios.get(url)
                    .then(function (res) {
                        if (res.status){
                            app.getNotifications();
                            if (link != '#') {
                                window.location.href = link
                            }
                        }
                    })
            },
            readAll() {
                let app = this;
                let url = "{{ route('user.push.notification.readAll') }}";
                axios.get(url)
                    .then(function (res) {
                        if (res.status){
                            app.items = [];
                        }
                    })
            },
            pushNewItem(){let app = this;
                // Pusher.logToConsole = true;
                let pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                    encrypted: true,
                    cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
                });
                let channel = pusher.subscribe('user-notification.' + "{{ Auth::id() }}");
                channel.bind('App\\Events\\UserNotification', function (data) {
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


                channel.bind('App\\Events\\UpdateUserNotification', function (data) {
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
