@extends(config('laravel_task_manager.task_master'))
@section('plugin_css')
@stop
@section('theme_plugin_js')
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/ui/headroom/headroom.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/ui/headroom/headroom_jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/ui/nicescroll.min.js')}}"></script>
    <script src="http://cdn.jsdelivr.net/npm/jquery.fancytree@2.27/dist/jquery.fancytree-all-deps.min.js"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/velocity/velocity.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/velocity/velocity.ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/buttons/spin.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/buttons/ladda.min.js')}}"></script>
@stop
@section('js_page')
@stop
@section('breadcrumb')
    <li><a href="{{route('ltm.clients.dashboard')}}"><i class="icon-home2 position-left"></i>داشبورد</a></li>
    <li class="active">مدیریت کاربران</li>
@stop
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <div class="row">
                        <h6 class="col-xs-8 panel-title">مدیریت کاربران</h6>
                        <span style="float: left;">
                        </span>
                    </div>
                </div>
                <div class="panel-body">
                        <div class="tabbable">
                            <ul class="nav nav-tabs nav-tabs-highlight" id="manage">
                                <li class="active">
                                    <a href="#users_view_tab" data-toggle="tab" class="legitRipple" aria-expanded="true">
                                        <span class="fa fa-list-alt"></span>لیست کاربران
                                    </a>
                                </li>
                                <li class=""><a href="#users_add_tab" data-toggle="tab" class="legitRipple" aria-expanded="false">
                                        <span class="fa fa-plus-circle"></span>افزودن کاربر
                                    </a>
                                </li>
                                <li class=""><a href="#users_edit_tab" data-toggle="tab" class="legitRipple" aria-expanded="false">
                                        <span class="fa fa-plus-circle"></span>ویرایش کاربر
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="users_view_tab">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <table id="GridData" class="table" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>{{trans('ltm_app.row')}}</th>
                                                    <th>نام</th>
                                                    <th>نام خانوادگی</th>
                                                    <th>نام کاربری</th>
                                                    <th>نوع کاربر</th>
                                                    <th>تصویر کاربر</th>
                                                    <th>پست الکترونیکی</th>
                                                    <th>کد ملی</th>
                                                    <th>شماره همراه</th>
                                                    <th>آدرس</th>
                                                    <th>{{trans('ltm_app.action')}}</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="users_add_tab">
                                    <div class="row">
                                        <div id="form_message_box_create" class="form_message_box_create"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <form id="form_created_user" class="form-horizontal" action="#">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-1">
                                                        <!-- user_type -->
                                                        <div class="form-group fg_user_type col-xs-12">
                                                            <label class="col-sm-2 control-label" for="user_type">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">نوع کاربر </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <select name="user_type" class="form-control user_type ">
                                                                    <option value="2">کاربر قانونی</option>
                                                                    <option value="1">کاربر معمولی</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- first_name -->
                                                        <div class="form-group fg_first_name col-xs-12">
                                                            <label class="col-sm-2 control-label" for="first_name">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">نام </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="first_name" class="form-control first_name ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- last_name -->
                                                        <div class="form-group fg_last_name col-xs-12">
                                                            <label class="col-sm-2 control-label" for="last_name">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">نام خانوادگی </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="last_name" class="form-control last_name ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- username -->
                                                        <div class="form-group fg_username col-xs-12">
                                                            <label class="col-sm-2 control-label" for="username">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">نام کاربری </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="username" class="form-control username ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- email -->
                                                        <div class="form-group fg_email col-xs-12">
                                                            <label class="col-sm-2 control-label" for="email">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">پست الکترونیکی </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="email" class="form-control email ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- password -->
                                                        <div class="form-group fg_password col-xs-12">
                                                            <label class="col-sm-2 control-label" for="password">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">گذرواژه </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="password" class="form-control password ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- password -->
                                                        <div class="form-group fg_password_confirmation col-xs-12">
                                                            <label class="col-sm-2 control-label" for="password_confirmation">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">تکرار گذرواژه </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="password_confirmation" class="form-control password_confirmation ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- melli_code -->
                                                        <div class="form-group fg_melli_code col-xs-12">
                                                            <label class="col-sm-2 control-label" for="melli_code">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">کد ملی </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="melli_code" class="form-control melli_code ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- mobile -->
                                                        <div class="form-group fg_mobile col-xs-12">
                                                            <label class="col-sm-2 control-label" for="mobile">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">تلفن همراه </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="mobile" class="form-control mobile ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- postal_code -->
                                                        <div class="form-group fg_postal_code col-xs-12">
                                                            <label class="col-sm-2 control-label" for="postal_code">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">کد پستی </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="postal_code" class="form-control postal_code ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- address -->
                                                        <div class="form-group fg_address col-xs-12">
                                                            <label class="col-sm-2 control-label" for="address">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">آدرس </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <textarea class="form-control address" name="address"></textarea>
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>

                                                        <div class="form-group  col-xs-12">
                                                            <hr/>
                                                        </div>
                                                        <!-- btn save form -->
                                                        <div class="form-group  col-xs-12" style="text-align:center">
                                                            <button type="submit" class="btn bg-primary btn-ladda btn-ladda-progress ladda-button " id="btn_save_form_user"
                                                                    data-style="slide-up" style="width: 120px;"><span
                                                                        class="ladda-label">ذخیره کاربر</span><span class="ladda-spinner"></span>
                                                                <div class="ladda-progress" style="width: 135px;"></div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="users_edit_tab">
                                    <div class="row">
                                        <div id="form_message_box_edit" class="form_message_box_edit"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <form id="form_edit_user" class="form-horizontal" action="#">
                                                <input type="hidden" name="item_id" class="item_id" value="">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-1">
                                                        <!-- user_type -->
                                                        <div class="form-group fg_user_type col-xs-12">
                                                            <label class="col-sm-2 control-label" for="user_type">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">نوع کاربر </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <select name="user_type" class="form-control user_type ">
                                                                    <option value="2">کاربر قانونی</option>
                                                                    <option value="1">کاربر معمولی</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- first_name -->
                                                        <div class="form-group fg_first_name col-xs-12">
                                                            <label class="col-sm-2 control-label" for="first_name">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">نام </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="first_name" class="form-control first_name ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- last_name -->
                                                        <div class="form-group fg_last_name col-xs-12">
                                                            <label class="col-sm-2 control-label" for="last_name">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">نام خانوادگی </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="last_name" class="form-control last_name ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- username -->
                                                        <div class="form-group fg_username col-xs-12">
                                                            <label class="col-sm-2 control-label" for="username">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">نام کاربری </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="username" class="form-control username ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- email -->
                                                        <div class="form-group fg_email col-xs-12">
                                                            <label class="col-sm-2 control-label" for="email">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">پست الکترونیکی </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="email" class="form-control email ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- password -->
                                                       {{-- <div class="form-group fg_password col-xs-12">
                                                            <label class="col-sm-2 control-label" for="password">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">گذرواژه </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="password" class="form-control password ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- password -->
                                                        <div class="form-group fg_password_confirmation col-xs-12">
                                                            <label class="col-sm-2 control-label" for="password_confirmation">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">تکرار گذرواژه </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="password_confirmation" class="form-control password_confirmation ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>--}}
                                                        <!-- melli_code -->
                                                        <div class="form-group fg_melli_code col-xs-12">
                                                            <label class="col-sm-2 control-label" for="melli_code">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">کد ملی </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="melli_code" class="form-control melli_code ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- mobile -->
                                                        <div class="form-group fg_mobile col-xs-12">
                                                            <label class="col-sm-2 control-label" for="mobile">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">تلفن همراه </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="mobile" class="form-control mobile ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- postal_code -->
                                                        <div class="form-group fg_postal_code col-xs-12">
                                                            <label class="col-sm-2 control-label" for="postal_code">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">کد پستی </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="postal_code" class="form-control postal_code ">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <!-- address -->
                                                        <div class="form-group fg_address col-xs-12">
                                                            <label class="col-sm-2 control-label" for="address">
                                                                <span class="more_info"></span>
                                                                <span class="red_star">*</span>
                                                                <span class="label_title">آدرس </span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <textarea class="form-control address" name="address"></textarea>
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>

                                                        <div class="form-group  col-xs-12">
                                                            <hr/>
                                                        </div>
                                                        <!-- btn save form -->
                                                        <div class="form-group  col-xs-12" style="text-align:center">
                                                            <button data-step_id="form_edit_item" type="button"
                                                                    class="btn bg-grey-300 cancel_form_btn">{{trans('ltm_app.submit_cancel')}} </button>
                                                            <button type="submit" class="btn btn-warning btn-ladda btn-ladda-progress ladda-button " id="btn_edit_form_user"
                                                                    data-style="slide-up" style="width: 120px;"><span
                                                                        class="ladda-label">ویرایش کاربر</span><span class="ladda-spinner"></span>
                                                                <div class="ladda-progress" style="width: 135px;"></div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_inline_javascript')
    @include('laravel_task_manager::backend.users.helper.index_inline_js')
@stop