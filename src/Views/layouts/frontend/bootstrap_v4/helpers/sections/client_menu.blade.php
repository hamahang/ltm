@if(auth()->check())
    <div class="container">
        <div class="row" id="client_menu">
            <nav class="navbar navbar-default no-margin">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{!! url('/clients/account/profile') !!}">
                            <span class="smaller-50"> کاربر گرامی: </span>
                            <span class="smaller-60">
                            {{--<img id="small_user_avatar" src="{{ auth()->user()->avatar_image }}" alt="" height="32" width="32" style="border-radius: 50%; margin: 0 3px 0 3px;">--}}
                            <strong>
                                {{auth()->user()->first_name.' '.auth()->user()->last_name}}
                            </strong>
                        </span>
                            <span class="smaller-50"> خوش آمدید </span>
                        </a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="@if(URL::current()==route('ltm.clients.dashboard')) active @endif"><a href="{{route('ltm.clients.dashboard')}}">پیشخوان </a></li>
                            <li style="margin-top: 15px; cursor: pointer; padding: 0px 15px;">
                                <div class="dropdown">
                                <span class=" dropdown-toggle"  data-toggle="dropdown">ثبت درخواست
                                    <span class="caret"></span></span>
                                    <ul class="dropdown-menu" id="list_proccess">
                                        {{--<li class="@if(URL::current()==route('clients.construction.form.start.index')) active_li @endif"><a href="{{route('clients.construction.form.start.index')}}">جواز تاسیس</a></li>--}}
                                        {{--<li class="@if(URL::current()==route('clients.LandPurchase.form.start.index')) active_li @endif"><a href="{{route('clients.LandPurchase.form.start.index')}}">درخواست زمین</a></li>--}}
                                        {{--<li class="@if(URL::current()==route('clients.ImportMachines.form.start.index')) active_li @endif"><a href="{{route('clients.ImportMachines.form.start.index')}}">ورود ماشین آلات</a></li>--}}
                                        {{--<li class="@if(URL::current()==route('clients.IssueLicense.form.start.index')) active_li @endif"><a href="{{route('clients.IssueLicense.form.start.index')}}">پروانه بهره برداری</a></li>--}}
                                    </ul>
                                </div>
                            </li>
                            {{--<li class="@if(URL::current()==route('ltm.clients.dashboard')) active @endif"><a href="{{ route('clients.account.profile') }}">حساب کاربری</a></li>--}}
                            {{--<li class="@if(URL::current()==route('auth.sso.logout')) active @endif"><a href="{{route('auth.sso.logout')}}">خروج</a></li>--}}
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </div>
    </div>
@endif