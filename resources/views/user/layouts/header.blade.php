
    <header class="headerNav">
        <div class="primary-header">
                <div class="primary-header-inner">
                    <div class="header-logo">
                        <div class="flex-logo">
                            <a href="{{route('home')}}">
                                <img class="logo" src="{{ getFile(config('location.logoIcon.path').'logo.png')}}" alt="Logo">
                            </a>
                            <div class="balance">
                                <span class="balance-span">{{Auth()->user()->balance}} {{config('basic.currency_symbol')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="header-menu-wrap">
                        <ul class="nav-menu">
                            <li class="{{ Request::routeIs('user.home')  ? 'active' : '' }}">
                                <a href="{{ route('user.home') }}">@lang('Dashboard')<span></span>
                                </a>
                            </li>
                            <li class="{{ Request::routeIs('about')  ? 'active' : '' }}">
                                <a href="{{ route('about') }}">@lang('About')  <span></span>
                                </a>
                            </li>
                            <li class="{{ Request::routeIs('user.order.index')  ? 'active' : '' }}">
                                <a href="{{ route('user.order.index') }}">@lang('Order') <span></span>
                                </a>
                            </li>
                            <li class="{{ Request::routeIs('user.service*')  ? 'active' : '' }}">
                                <a href="{{ route('user.service.show') }}">@lang('Services') <span></span>
                                </a>
                            </li>
                            <li class="{{ Request::routeIs('user.transaction') ? 'active' : '' }}">
                                <a href="{{ route('user.transaction') }}">@lang('Transactions') <span></span>
                                </a>
                            </li>
                            <li class="{{ Request::routeIs('user.debt') ? 'active' : '' }}">
                                <a href="{{ route('user.debt') }}">@lang('Debt') <span></span>
                                </a>
                            </li>
                            <li class="{{ Request::routeIs('privacy-policy')  ? 'active' : '' }}">
                                <a href="{{ route('privacy-policy') }}">@lang('privacy-policy') <span></span>
                                </a>
                            </li>
                            <li class="dropdown_menu">
                                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdownUser"
                                       role="button"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        <img src="{{getFile(config('location.user.path').Auth::user()->image )}}"
                                             alt="{{ Auth::user()->name }}" class="rounded-circle" width="40px">
                                        <span>{{ Auth::user()->username }}</span>
                                        <i data-feather="chevron-down" class="svg-icon"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownUser">
                                        <a class="dropdown-item {{menuActive('user.profile')}}" href="{{ route('user.profile') }}">
                                            <i data-feather="user" class="svg-icon mr-2 ml-1"></i>
                                            @lang('My Profile')</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                                data-feather="power" class="svg-icon mr-2 ml-1"></i>
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                               <span class="dropdown-plus"></span>
                            </li>
                        </ul>
                    </div>
                    <div class="header-right">
                        <div class="mobile-menu-icon">
                            <div class="burger-menu">
                                <div class="line-menu line-half first-line"></div>
                                <div class="line-menu"></div>
                                <div class="line-menu line-half last-line"></div>
                            </div>
                        </div>
                        <!-- Notification -->
                        <div class="push-notification dropdown " id="pushNotificationArea">

                            <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                               id="bell" role="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <span><i class="far fa-bell bell-font"></i></span>
                                <span class="badge badge-primary notify-no rounded-circle" v-cloak>@{{ items.length }}</span>
                            </a>

                            <div class="right-dropdown dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <ul class="list-style-none">
                                    <li>
                                        <div class="scrollable message-center notifications position-relative">

                                            <!-- Message -->
                                            <a v-for="(item, index) in items"
                                               @click.prevent="readAt(item.id, item.description.link)"
                                               href="javascript:void(0)"
                                               class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <span class="btn btn-success text-white">
                                                    <i :class="item.description.icon" class="text-white"></i>
                                                </span>
{{--                                                rounded-circle btn-circle--}}
                                                <div class="d-inline-block v-middle pl-2">
                                        <span class="font-12  d-block text-muted" v-cloak
                                              v-html="item.description.text"></span>
                                                    <span class="font-12  d-block text-muted text-truncate" v-cloak>@{{ item.formatted_date }}</span>
                                                </div>
                                            </a>

                                        </div>
                                    </li>

                                    <li>
                                        <a class="nav-link pt-3 text-center text-dark notification-clear-btn"
                                           href="javascript:void(0);"
                                           v-if="items.length > 0" @click.prevent="readAll">
                                            <strong>@lang('Clear all')</strong>
                                        </a>
                                        <a class="nav-link pt-3 text-center text-dark" href="javascript:void(0);"
                                           v-else>
                                            <strong>@lang('No Data found')</strong>
                                        </a>

                                    </li>
                                </ul>
                            </div>


                        </div>
                        <!-- End Notification -->

                        <div class="push-notification language">
                            <a class="nav-link dropdown-toggle lin" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                               style="background-color: transparent;">
                                {{--                    @lang('Languages')--}}
                                <i class="fa fa-globe bell-font"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                @foreach(getLanguges() as $language)
                                    <a class="dropdown-item" href="{{route('language',[$language->short_name])}}">
                                        {{$language->name}}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </header>
