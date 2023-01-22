@extends('laravel_task_manager::layouts.frontend.bootstrap_v4.master')

@section('title', 'ثبت نام')
@section('content')
    <div class="space-10"></div>
    <fieldset>
        <legend>
            <h4>تماس با ما</h4>
        </legend>
        <div class="row">
            <div class="col-sm-7">
                <div class="panel panel-default">
                    <div class="panel-heading">
                <span>
                    <i class="fa fa-envelope-o fa-fw co10 fa-2x"></i>
                    <span> اطلاعات تماس </span>
                </span>
                    </div>
                    <div class="panel-body">
                        <div class="recent-post">
                            <ul class="about" style="list-style: none;">
                                  <li >
                                      <i class="fa fa-map-marker"></i>
                                    <label class="def_label">آدرس :</label>
                                    <div style="padding-right: 15px;">
                                        <span class="value def_value" > ساختمان شماره 1: تهران، خیابان ولی عصر (عج) بالاتر از ظفر، بلوار اسفندیار، پلاک 5  کدپستی: 1967915773 </span>
                                    </div>
                                    <div style="padding-right: 15px;">
                                        <span class="value def_value"> ساختمان شماره 2: خیابان ولی عصر (عج) بالاتر از اسفندیار، خیابان  رحیمی، پلاک 58  </span>
                                    </div>
                                    <div class="clear"></div>
                                </li>
                                <div class="space-10"></div>
                                <i class="fa fa-envelope"></i>
                                    <label class="def_label">رایانامه (ایمیل) :</label>
                                    <div style="padding-right: 15px;">
                                    <span class="value text-left dir-left def_value">publicrelations@freezones.ir</span>
                                     </div>
                                    <div class="clear"></div>
                                </li>
                                <div class="space-10"></div>
                                <li>
                                    <i class="fa fa-phone"></i>
                                    <label class="def_label">تلفن ثابت :</label>
                                    <div style="padding-right: 15px;">
                                        <span class="value text-left dir-left def_value">021-7520700</span>
                                    </div>
                                    <div class="clear"></div>
                                </li>
                                <div class="space-10"></div>
                                <li>
                                    <i class="fa fa-comment"></i>
                                    <label class="def_label">سامانه پیام کوتاه :</label>
                                    <div style="padding-right: 15px;">
                                        <span class="value text-left dir-left def_value">021-22039336</span>
                                    </div>
                                    <div class="clear"></div>
                                </li>
                                <div class="space-10"></div>
                                <li>
                                    <i class="fa fa-phone"></i>
                                    <label class="def_label">فکس دبیرخانه مرکزی :</label>
                                    <div style="padding-right: 15px;">
                                        <span class="value text-left dir-left def_value">021-7520700</span>
                                    </div>
                                    <div class="clear"></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                <span>
                    <i class="fa fa-envelope-o fa-fw co10 fa-2x"></i>
                    <span> آدرس برروی نقشه : </span>
                </span>
                    </div>
                    <div class="panel-body">
                        <div class="recent-post">

                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfixed"></div>
        </div>
    </fieldset>
    <div class="space-32"></div>
    <div class="space-32"></div>
@stop