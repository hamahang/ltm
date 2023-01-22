<div class="panel panel-flat">
    <div class="panel-body">
        <form id="user_template" role="form" method="POST" action="" enctype="multipart/form-data">
            <!-- file input user logo -->
            <div class="form-group fg_file_input_user_logo col-xs-12">
                <label class="col-sm-2 control-label" for="file_input_user_logo">
                    <span class="more_info"></span>
                    <span class="red_star">*</span>
                    <span class="label_title">لوگو قالب </span>
                </label>
                <div class="col-sm-6">
                    {!! $logo_user['button'] !!}
                </div>
                <div class="col-sm-4 messages"><p class="help-block error"><strong>لوگو قالب الزامی است.</strong></p></div>
            </div>
            <div id="show_area_user">
                @if($logo_user_view)
                    {!! $logo_user_view['view']['medium'] !!}
                @endif
            </div>
            <!-- text footer -->
            <div class="form-group fg_text_footer_user col-xs-12">
                <label class="col-sm-2 control-label" for="text_footer_user">
                    <span class="more_info"></span>
                    <span class="red_star">*</span>
                    <span class="label_title">پاورقی قالب </span>
                </label>
                <div class="col-sm-6">
                    @if($template_satting_user)
                        <input type="text" value="{{$template_satting_user->text_footer}}"  name="text_footer_user" class="form-control text_footer_user ">
                    @else
                        <input type="text" name="text_footer_user" class="form-control text_footer_user ">
                    @endif

                </div>
                <div class="col-sm-4 messages"><p class="help-block error"><strong>پاورقی قالب الزامی است.</strong></p></div>
            </div>
            <!-- theme nav -->
            <div class="form-group fg_theme_nav_user col-xs-12">
                <label class="col-sm-2 control-label" for="theme_nav_user">
                    <span class="more_info"></span>
                    <span class="red_star">*</span>
                    <span class="label_title">رنگ نوار ابزار</span>
                </label>
                <div class="col-sm-6">
                    <select name="theme_nav_user" class="form-control theme_nav_user">
                        @if($template_satting_user)
                            @if($template_satting_user->theme_nav == 'navbar-inverse')
                                <option selected="selected" value="navbar-inverse">مشکی</option>
                                <option value="navbar-default">سفید</option>
                            @else
                                <option value="navbar-inverse">مشکی</option>
                                <option selected="selected" value="navbar-default">سفید</option>
                            @endif
                        @else
                            <option value="navbar-inverse">مشکی</option>
                            <option  value="navbar-default">سفید</option>
                        @endif
                    </select>
                </div>
                <div class="col-sm-4 messages"><p class="help-block error"><strong>رنگ نوار ابزار الزامی است.</strong></p></div>
            </div>
            <!-- theme sidebar -->
            <div class="form-group fg_theme_sidebar_user col-xs-12">
                <label class="col-sm-2 control-label" for="theme_sidebar_user">
                    <span class="more_info"></span>
                    <span class="red_star">*</span>
                    <span class="label_title">رنگ ساید بار</span>
                </label>
                <div class="col-sm-6">
                    <select name="theme_sidebar_user" class="form-control theme_sidebar_user">
                        @if($template_satting_user)
                            @if($template_satting_user->theme_sidebar == 'sidebar')
                                <option selected="selected" value="sidebar">مشکی</option>
                                <option value="sidebar-default">سفید</option>
                            @else
                                <option value="sidebar">مشکی</option>
                                <option selected="selected" value="sidebar-default">سفید</option>
                            @endif
                        @else
                            <option value="sidebar">مشکی</option>
                            <option value="sidebar-default">سفید</option>
                        @endif
                    </select>
                </div>
                <div class="col-sm-4 messages"><p class="help-block error"><strong>رنگ ساید بار الزامی است.</strong></p></div>
            </div>
            <!-- btn save form -->
            <div class="form-group  col-xs-12">
                <button type="button" class="btn bg-primary btn-ladda btn-ladda-progress ladda-button pull-right " id="btn_save_form_user_template"
                        data-style="slide-up" style="width: 120px;"><span
                            class="ladda-label">ذخیره تنظیمات</span><span class="ladda-spinner"></span>
                    <div class="ladda-progress" style="width: 135px;"></div>
                </button>
            </div>
        </form>
    </div>
</div>
@include('laravel_task_manager::backend.templates.user_template.helper.index_inline_js')