<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
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
</div>