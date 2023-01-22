@extends(config('laravel_task_manager.task_master'))
@section(config('laravel_task_manager.task_master_yield_plugin_js'))
    <script type="text/javascript" src="{{asset('vendor/laravel_task_manager/build/backend/js/dashboard.min.js')}}"></script>
@stop
@section(config('laravel_task_manager.task_master_yield_content'))
    <!-- -->
    <button class="btn btn-primary jsPanels" data-href="{!! route('ltm.modals.common.tasks.task.add') !!}" data-reload="reload">افزودن</button>
    <!-- -->










    <!-- Timeline -->
    <div class="timeline timeline-left">
        <div class="timeline-container">
            <div class="timeline-date text-muted">
                <i class="icon-history position-left"></i> <span class="text-semibold">Monday</span>, April 18
            </div>
            <div class="timeline-row">
                <div class="timeline-icon">
                    <img src="/vendor/laravel_task_manager/images/placeholder.jpg" alt="">
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-flat timeline-content">
                            <div class="panel-heading">
                                <h6 class="panel-title">Himalayan sunset</h6>
                                <div class="heading-elements">
                                    <span class="heading-text"><i class="icon-checkmark-circle position-left text-success"></i> 49 minutes ago</span>
                                    <ul class="icons-list">
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="icon-arrow-down12"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a href="#"><i class="icon-user-lock"></i> Hide user posts</a></li>
                                                <li><a href="#"><i class="icon-user-block"></i> Block user</a></li>
                                                <li><a href="#"><i class="icon-user-minus"></i> Unfollow user</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#"><i class="icon-embed"></i> Embed post</a></li>
                                                <li><a href="#"><i class="icon-blocked"></i> Report this post</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                <a href="#" class="display-block content-group">
                                    <img src="/vendor/laravel_task_manager/images/cover.jpg" class="img-responsive content-group" alt="">
                                </a>

                                <h6 class="content-group">
                                    <i class="icon-comment-discussion position-left"></i>
                                    <a href="#">Jason Ansley</a> commented:
                                </h6>
                                <blockquote>
                                    <p>When suspiciously goodness labrador understood rethought yawned grew piously endearingly inarticulate oh goodness jeez trout distinct hence cobra despite taped laughed the much audacious less inside tiger groaned darn stuffily metaphoric unihibitedly inside cobra.</p>
                                    <footer>Jason, <cite title="Source Title">10:39 am</cite></footer>
                                </blockquote>
                            </div>
                            <div class="panel-footer panel-footer-transparent">
                                <div class="heading-elements">
                                    <ul class="list-inline list-inline-condensed heading-text">
                                        <li><a href="#" class="text-default"><i class="icon-eye4 position-left"></i> 438</a></li>
                                        <li><a href="#" class="text-default"><i class="icon-comment-discussion position-left"></i> 71</a></li>
                                    </ul>
                                    <span class="heading-btn pull-right">
											<a href="#" class="btn btn-link">Read post <i class="icon-arrow-left13 position-right"></i></a>
										</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-flat timeline-content">
                            <div class="panel-heading">
                                <h6 class="panel-title">Diving lesson in Dubai</h6>
                                <div class="heading-elements">
                                    <span class="heading-text"><i class="icon-checkmark-circle position-left text-success"></i> 3 hours ago</span>
                                    <ul class="icons-list">
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="icon-arrow-down12"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a href="#"><i class="icon-user-lock"></i> Hide user posts</a></li>
                                                <li><a href="#"><i class="icon-user-block"></i> Block user</a></li>
                                                <li><a href="#"><i class="icon-user-minus"></i> Unfollow user</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#"><i class="icon-embed"></i> Embed post</a></li>
                                                <li><a href="#"><i class="icon-blocked"></i> Report this post</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                <a href="#" class="display-block content-group">
                                    <img src="/vendor/laravel_task_manager/images/cover.jpg" class="img-responsive" alt="">
                                </a>
                                <h6 class="content-group">
                                    <i class="icon-comment-discussion position-left"></i>
                                    <a href="#">Melanie Watson</a> commented:
                                </h6>
                                <blockquote>
                                    <p>Pernicious drooled tryingly over crud peaceful gosh yet much following brightly mallard hey gregariously far gosh until earthworm python some impala belched darn a sighed unicorn much changed and astride cat and burned grizzly when jeez wonderful the outside tedious.</p>
                                    <footer>Melanie, <cite title="Source Title">12:56 am</cite></footer>
                                </blockquote>
                            </div>
                            <div class="panel-footer panel-footer-transparent">
                                <div class="heading-elements">
                                    <ul class="list-inline list-inline-condensed heading-text">
                                        <li><a href="#" class="text-default"><i class="icon-eye4 position-left"></i> 438</a></li>
                                        <li><a href="#" class="text-default"><i class="icon-comment-discussion position-left"></i> 71</a></li>
                                    </ul>
                                    <span class="heading-btn pull-right">
											<a href="#" class="btn btn-link">Read post <i class="icon-arrow-left13 position-right"></i></a>
										</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop