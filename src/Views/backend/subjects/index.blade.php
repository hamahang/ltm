@extends(config('laravel_task_manager.task_master'))

@section('plugin_js')
    <script src="http://cdn.jsdelivr.net/npm/jquery.fancytree@2.27/dist/jquery.fancytree-all-deps.min.js"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/velocity/velocity.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/velocity/velocity.ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/buttons/spin.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/buttons/ladda.min.js')}}"></script>
@stop

@section('breadcrumb')
    <li><a href="{{route('ltm.clients.dashboard')}}"><i class="icon-home2 position-left"></i>داشبورد</a></li>
    <li class="active">موضوعات</li>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <div class="row">
                        <h6 class="col-xs-8 panel-title">
                            {{trans('ltm_app.titles')}}
                        </h6>
                        <span style="float: left;">
                        </span>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="tabbable">
                        <ul class="nav nav-tabs nav-tabs-highlight" id="manage">
                            <li class="active">
                                <a href="#manage_tab" data-toggle="tab" class="legitRipple" aria-expanded="true">
                                    <span class="fa fa-list-alt"></span>
                                    {{trans('ltm_backend.manage_titles')}}
                                </a>
                            </li>
                            <li class=""><a href="#add_tab" data-toggle="tab" class="legitRipple" aria-expanded="false">
                                    <span class="fa fa-plus-circle"></span>
                                    {{trans('ltm_backend.add_a_new_title')}}
                                </a>
                            </li>
                            <li class="">
                                <a href="#tree_title_tab" data-toggle="tab" class="legitRipple" aria-expanded="false">
                                    <span class="fa fa-plus-circle"></span>
                                    {{trans('ltm_backend.tree_title')}}
                                </a>
                            </li>
                            <li class="">
                                <a href="#test" data-toggle="tab" class="legitRipple" aria-expanded="false">
                                    <span class="fa fa-plus-circle"></span>
                                    <span>تست</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="manage_tab">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="row">
                                            <div class="col-xs-1"> فیلتر گروه:</div>
                                            <div class="col-xs-5">
                                                <select id="filter" class="form-control filter" name="filter">
                                                    @foreach($subjects as $subject)
                                                        <option value="{{ $subject->id }}">{{ $subject->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xs-6">
                                                <button type="button" class="btn btn-primary btn_filter">اعمال فیلتر</button>
                                            </div>
                                        </div>
                                        <hr>
                                        <table id="GridData" class="table" width="100%">
                                            <thead>
                                            <tr>
                                                <th>{{trans('ltm_app.row')}}</th>
                                                <th>{{trans('ltm_app.code')}}</th>
                                                <th>{{trans('ltm_app.title')}}</th>
                                                <th>{{trans('ltm_app.parent')}}</th>
                                                <th>{{trans('ltm_app.created_by')}}</th>
                                                <th>{{trans('ltm_app.created_at')}}</th>
                                                <th>{{trans('ltm_app.order')}}</th>
                                                <th>{{trans('ltm_app.action')}}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="add_tab">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <form id="form_created_new" class="form-horizontal" action="#">
                                            <div class="row">
                                                <div class="col-md-10 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">{{ trans('ltm_backend.subject_code') }}</label>
                                                        <div class="col-lg-9">
                                                            <input name="code" type="text" class="form-control" placeholder="{{ trans('ltm_backend.subject_code') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">{{trans('ltm_app.subject')}}</label>
                                                        <div class="col-lg-9">
                                                            <input name="title" type="text" class="form-control" placeholder="{{trans('ltm_backend.subject_title')}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">{{trans('ltm_backend.root')}}</label>
                                                        <div class="col-lg-9">
                                                            <select id="title_list" data-placeholder="{{trans('ltm_backend.select_title')}}"
                                                                    class="form-control select" name="subject_id">
                                                                <option value="0">{{ trans('ltm_app.no_parent') }}</option>
                                                                @foreach($subjects as $subject)
                                                                    <option value="{{ $subject->id }}">{{ $subject->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">{{ trans('ltm_backend.background_color') }}</label>
                                                        <div class="col-lg-9">
                                                            <input class="form-control" id="background_color" name="background_color" type="text" placeholder="{{ trans('ltm_backend.background_color') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">{{ trans('ltm_backend.text_color') }}</label>
                                                        <div class="col-lg-9">
                                                            <input class="form-control" id="text_color" name="text_color" type="text" placeholder="{{ trans('ltm_backend.text_color') }}">
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <button data-step_id="form_created_new" type="button" class="btn bg-grey-300 cancel_form_btn">{{trans('ltm_app.submit_cancel')}} </button>
                                                        <button data-step_id="form_created_new" type="button" class="btn btn-primary submit_form_btn"><i class="fa fa-save"></i> {{trans('ltm_app.submit_add')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade  in" id="tree_title_tab">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <!-- Default unordered list markup -->
                                        <div class="panel panel-flat">
                                            <div class="panel-heading">
                                                <h6 class="panel-title">نمایش درختی موضوعات</h6>
                                                <div class="heading-elements">
                                                    <ul class="icons-list">
                                                        <li><a data-action="collapse"></a></li>
                                                        <li><a data-action="reload"></a></li>
                                                        <li><a data-action="close"></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div id="tree"></div>
                                            </div>
                                        </div>
                                        <!-- /default unordered list markup -->
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="edit_tab">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <form id="form_edit_item" class="form-horizontal" action="#">
                                            <input id="title_item_id" type="hidden" name="item_id" value="">
                                            <div class="row">
                                                <div class="col-md-10 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">{{ trans('ltm_backend.subject_code') }}</label>
                                                        <div class="col-lg-9">
                                                            <div id="edit_form_input_code" type="text" class="" style="margin-top: 10px;"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">{{trans('ltm_app.subject')}}</label>
                                                        <div class="col-lg-9">
                                                            <input id="edit_form_input_title" name="title" type="text" class="form-control" placeholder="{{ trans('ltm_backend.subject_title') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">{{ trans('ltm_backend.root') }}</label>
                                                        <div class="col-lg-9">
                                                            <select id="edit_form_input_title_list" data-placeholder="{{trans('ltm_backend.select_root')}}" class="form-control select" name="subject_id">
                                                                <option value="0">{{ trans('ltm_app.no_parent') }}</option>
                                                                @foreach($subjects as $subject)
                                                                    <option value="{{ $subject->id }}">{{ $subject->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">{{ trans('ltm_backend.background_color') }}</label>
                                                        <div class="col-lg-9">
                                                            <input class="form-control" id="edit_form_input_background_color" name="background_color" type="text" placeholder="{{ trans('ltm_backend.background_color') }}" value="{!! @$subject->background_color !!}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">{{ trans('ltm_backend.text_color') }}</label>
                                                        <div class="col-lg-9">
                                                            <input class="form-control" id="edit_form_input_text_color" name="text_color" type="text" placeholder="{{ trans('ltm_backend.text_color') }}" value="{!! @$subject->text_color !!}">
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <button data-step_id="form_edit_item" type="button" class="btn bg-grey-300 cancel_form_btn">{{trans('ltm_app.submit_cancel')}} </button>
                                                        <button data-step_id="form_edit_item" type="button" class="btn bg-warning-400 submit_form_btn"><i class="fa fa-save"></i> {{trans('ltm_app.submit_edit')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="test">
                                <div class="row form-horizontal">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">انتخاب موضوع</label>
                                        <div class="col-lg-9">
                                            <select data-placeholder="{{trans('ltm_backend.select_title')}}" class="form-control select_subject">
                                                @foreach($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">انتخاب ردیف</label>
                                        <div class="col-lg-9">
                                            <select data-placeholder="{{trans('ltm_backend.select_title')}}" class="form-control select_row"></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label"></label>
                                        <div class="col-lg-9">
                                            <button type="button" class="btn bg-primary btn-ladda btn-ladda-progress ladda-button ladda_button" data-style="slide-up" style="width: 120px;"><span class="ladda-label">گرفتن قالب</span><span class="ladda-spinner"></span>
                                                <div class="ladda-progress" style="width: 135px;"></div>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label"></label>
                                        <div class="col-lg-9">
                                            <div class="panel_template"></div>
                                        </div>
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
    @include('laravel_task_manager::backend.subjects.helper.script')
@stop