<?php

return [

    /* Important Settings */
    'backend_ltm_middlewares'                        => explode(',', env('LTM_BACKEND_MIDDLEWARES', 'web')),
    'client_ltm_middlewares'                         => explode(',', env('LTM_FRONTEND_MIDDLEWARES', 'web')),
    'backend_ltm_route_prefix'                       => env('LTM_BACKEND_ROUTE_PERFIX', 'ltm'),
    'client_ltm_route_prefix'                        => env('LTM_CLIENT_ROUTE_PERFIX', 'ltm'),
    // ======================================================================
    'user_model'                                     => env('LTM_USER_MODEL', 'App\User'),
    'logout_route'                                   => env('LTM_LOGOUT_ROUTE', 'auth.sso.logout'),
    'site_dashboard_route'                           => env('SITE_DASHBOARD_ROUTE', 'backend.task.dashboard'),
    'site_create_task_route'                         => env('SITE_CREATE_TASK_ROUTE', 'backend.task.create_task'),
    'site_my_task_route'                             => env('SITE_MYTASK_ROUTE', 'backend.task.my_task'),
    'site_assigned_task_route'                       => env('SITE_ASSIGNED_TASK_ROUTE', 'backend.task.assigned_task'),
    'site_transcripted_task_route'                   => env('SITE_ASSIGNED_TASK_ROUTE', 'backend.task.transcripted_task'),
    'site_subject_route'                             => env('SITE_SUBJECT_ROUTE', 'backend.task.subject'),
    'site_setting_route'                             => env('SITE_SETTING_ROUTE', 'backend.task.setting'),
    'task_master'                                    => env('LTM_TASK_MASTER', 'laravel_task_manager::layouts.clients.limitless_v16.master_content'),
    'task_master_yield_content'                      => env('LTM_TASK_MASTER_YIELD_CONTENT', 'content'),
    'task_master_yield_page_title'                   => env('LTM_TASK_MASTER_YIELD_PAGE_TITLE', 'page_title'),
    'task_master_yield_plugin_css'                   => env('LTM_TASK_MASTER_YIELD_PLUGIN_CSS', 'plugin_css'),
    'task_master_yield_inline_style'                 => env('LTM_TASK_MASTER_YIELD_INLINE_STYLE', 'inline_style'),
    'task_master_yield_plugin_js'                    => env('LTM_TASK_MASTER_YIELD_PLUGIN_JS', 'plugin_js'),
    'task_master_yield_inline_javascript'            => env('LTM_TASK_MASTER_YIELD_INLINE_JAVASCRIPT', 'inline_javascript'),
    'task_master_yield_modals'                       => env('LTM_TASK_MASTER_YIELD_INLINE_MODALS', 'modals'),
    'task_master_yield_footer_inline_javascript'     => env('LTM_TASK_MASTER_YIELD_FOOTER_INLINE_JAVASCRIPT', 'footer_inline_javascript'),
    'task_master_yield_footer_plugin_js'             => env('LTM_TASK_MASTER_YIELD_FOOTER_PLUGIN_JS', 'footer_plugin_js'),
    'task_master_yield_breadcrumb'                   => env('LTM_TASK_MASTER_YIELD_BREADCRUMB', 'breadcrumb'),
    'task_assigments_default_users_id_function_name' => env('LTM_TASK_ASSIGMENTS_DEFAULT_USERS_ID_FUNCTION_NAME', 'ltm_task_assigments_default_users_id'),
    'task_assigments_users_id_function_name'         => env('LTM_TASK_ASSIGMENTS_USERS_ID_FUNCTION_NAME', 'ltm_task_assigments_users_id'),
    'task_assigments_subject_function_name'          => env('LTM_TASK_ASSIGMENTS_SUBJECT_FUNCTION_NAME', 'ltm_task_assigments_subjects'),
    'task_file_no_list'                              => env('LTM_TASK_FILE_NUMBER_FUNCTION', 'ltm_get_file_no_list'),
    'task_file_no_list_in_clients_function_name'     => env('LTM_TASK_FILE_NUMBER_LIST_IN_CLIENT_FUNCTION_NAME', 'ltm_get_file_no'),
    'task_profile_client_route_name'                 => env('LTM_TASK_PROFILE_CLIENT_ROUTE_NAME', 'clients.account.profile'),
    'task_show_in_client'                            => env('LTM_TASK_SHOW_IN_CLIENT', true),
    'task_show_in_hamahanag'                         => env('LTM_TASK_SHOW_IN_HAMAHANG', true),
    'task_show_in_backend'                           => env('LTM_TASK_SHOW_IN_BACKEND', true),
    'task_get_step_function_name'                    => env('LTM_TASK_GET_STEP_FUNCTION_NAME', 'ltm_get_step'),
    'task_get_user_id'                               => env('LTM_TASK_GET_USER_ID', 'ltm_get_user_id'),
    'task_show_client_route_function_name'           => env('LTM_TASK_SHOW_CLIENT_FUNCTION_NAME', 'ltm_show_client_route'),
    'task_assigment_user_for_select2'                => env('LTM_TASK_ASSIGMENT_USER', 'ltm_task_assigment_select2'),
    'client_task_user_transcript_array_id'           => env('LTM_CLIENT_TASK_USER_TRANSCRIPT_ARRAY_ID', 'ltm_task_transcript_user_id'),

    //--------------------------------------sms and email config
    'send_sms_after_task_create_from_client'         => env('LTM_SEND_SMS_AFTER_TASK_CREATE_FROM_CLIENT', true),
    'send_email_after_task_create_from_client'       => env('LTM_SEND_EMAIL_AFTER_TASK_CREATE_FROM_CLIENT', true),
    'send_sms_after_task_create_from_backend'        => env('LTM_SEND_SMS_AFTER_TASK_CREATE_FROM_BACKEND', true),
    'send_email_after_task_create_from_backend'      => env('LTM_SEND_EMAIL_AFTER_TASK_CREATE_FROM_BACKEND', true),

];