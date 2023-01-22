@php
    $front_settings = [];
    /*front_settings()*/
@endphp
<header id="header_area" style="border-bottom: 2px solid #114152; border-top: 1px solid #114152; background-image: none;">
    <div class="container" style="position: relative;">
        <div style="min-height: 80px; text-align: center;"></div>
        <div style="min-height: 70px; text-align: center;">
            <div class="header_menu d-none d-sm-none d-md-block d-lg-block">
                <ul class="no-padding no-margin">
                    <li class="@if(URL::current()==route('auth.sso.login')) active @endif" title="صفحه اصلی">
                        <a href="{{route('auth.sso.login')}}" title="صفحه اصلی">صفحه اصلی</a>
                    </li>
                    <li class="@if(URL::current()==route('frontend.pages.about')) active @endif" title="درباره ما">
                        <a href="{{route('frontend.pages.about')}}" title="درباره ما">درباره ما</a>
                    </li>
                    <li class="@if(URL::current()==route('frontend.pages.contact')) active @endif" title="تماس با ما">
                        <a href="{{route('frontend.pages.contact')}}" title="تماس با ما">تماس با ما</a>
                    </li>
                    <li class="@if(URL::current()==route('frontend.pages.rules')) active @endif" title="قوانین و مقررات">
                        <a href="{{route('frontend.pages.rules')}}" title="قوانین و مقررات">قوانین و مقررات</a>
                    </li>
                    <li class="@if(URL::current()==route('auth.sso.register')) active @endif" title=">ثبت نام">
                        <a href="{{route('auth.sso.register')}}" title="ثبت نام">ثبت نام</a>
                    </li>
                    <div class="clearfixed"></div>
                </ul>
                <div class="clearfixed"></div>
            </div>

        </div>
        {{--
        <div style="position: absolute; left: 10px; top: 10px;">
            <a href="{{ @$front_settings['header']->left_logo->link }}" title="{{ @$front_settings['header']->left_logo->title }}">
                <img src="{{ @$front_settings['header']->left_logo->src }}" style="max-height: 108px;">
            </a>
        </div>
        <div class="header_left">
            <h5>
                <a href="{{ @$front_settings['header']->right_logo->link }}">
                    <img style="max-height: 70px" src="{{ @$front_settings['header']->right_logo->src }}" title="{{ @$front_settings['header']->right_logo->title }}">
                </a>
                @if(isset($front_settings['header']) && !$front_settings['header']->right_logo->src)
                    <span>{{ @$front_settings['header']->right_logo->title }}</span>
                @endif
            </h5>
            <div class="menu_btn_open_sm d-lg-none d-md-none" onclick="openNav()">
                <i class="fa fa-bars"></i>
            </div>
            <div class="header_menu d-none d-sm-none d-md-block d-lg-block">
                <ul class="no-padding no-margin">
                    <li class="@if(URL::current()==route('auth.sso.login')) active @endif" title="صفحه اصلی">
                        <a href="{{route('auth.sso.login')}}" title="صفحه اصلی">صفحه اصلی</a>
                    </li>
                    <li class="@if(URL::current()==route('frontend.pages.about')) active @endif" title="درباره ما">
                        <a href="{{route('frontend.pages.about')}}" title="درباره ما">درباره ما</a>
                    </li>
                    <li class="@if(URL::current()==route('frontend.pages.contact')) active @endif" title="تماس با ما">
                        <a href="{{route('frontend.pages.contact')}}" title="تماس با ما">تماس با ما</a>
                    </li>
                    <li class="@if(URL::current()==route('frontend.pages.rules')) active @endif" title="قوانین و مقررات">
                        <a href="{{route('frontend.pages.rules')}}" title="قوانین و مقررات">قوانین و مقررات</a>
                    </li>
                    <li class="@if(URL::current()==route('auth.sso.register')) active @endif" title=">ثبت نام">
                        <a href="{{route('auth.sso.register')}}" title="ثبت نام">ثبت نام</a>
                    </li>
                    <div class="clearfixed"></div>
                </ul>
                <div class="clearfixed"></div>
            </div>
        </div>
        --}}
    </div>
</header>