<?php

Route::group(['prefix' => config('laravel_task_manager.backend_ltm_route_prefix'), 'namespace' => 'Hamahang\LTM\Controllers', 'middleware' => config('laravel_task_manager.backend_ltm_middlewares')], function () {
   Route::group(['prefix' => 'modals', 'namespace' => 'Modals', ], function()
    {
        Route::group(['prefix' => 'common', 'namespace' => 'Common', ], function()
        {
            Route::group(['prefix' => 'tasks', 'namespace' => 'Tasks', /*'middleware' => ['auth'], */], function()
            {
                Route::group(['prefix' => 'my_assigned_tasks', ], function()
                {
                    Route::post('view', ['uses' => 'TaskController@view', 'as' => 'ltm.modals.common.tasks.my_assigned_tasks.view', ]);
                });
                Route::group(['prefix' => 'my_tasks', ], function()
                {
                    Route::post('view', ['uses' => 'TaskController@view', 'as' => 'ltm.modals.common.tasks.my_tasks.view', ]);
                });
                Route::group(['prefix' => 'my_transcript_tasks', ], function()
                {
                    Route::post('view', ['uses' => 'TaskController@view', 'as' => 'ltm.modals.common.tasks.my_transcript_tasks.view', ]);
                });
                Route::group(['prefix' => 'task', ], function()
                {
                    Route::post('add', ['uses' => 'TaskController@add', 'as' => 'ltm.modals.common.tasks.task.add', ]);
                    Route::post('integrate', ['uses' => 'TaskController@integrate', 'as' => 'ltm.modals.common.tasks.task.integrate', ]);
                });
            });
        });
    });

    Route::group(['prefix' => 'clients', 'namespace' => 'Clients'], function()
    {
        Route::group(['prefix' => 'dashboard'], function()
        {
            Route::get('/', ['uses' => 'AccountController@dashboardIndex', 'as' => 'ltm.clients.dashboard' ]);
            Route::post('get_requests', ['uses' => 'AccountController@getRequests', 'as' => 'ltm.account.get_requests', ]);
        });
        Route::group(['prefix' => 'tasks', 'namespace' => 'Tasks', ], function()
        {
            Route::group(['prefix' => 'create_task', ], function()
            {
                Route::get('/', ['uses' => 'TaskController@create_task_view', 'as' => 'ltm.clients.tasks.create_task_view', ]);
            });
            Route::group(['prefix' => 'my_assigned_tasks', ], function()
            {
                Route::get('/', ['uses' => 'MyAssignedTaskController@index', 'as' => 'ltm.clients.tasks.my_assigned_tasks.index', ]);
                Route::post('datatable_get', ['uses' => 'MyAssignedTaskController@datatable_get', 'as' => 'ltm.clients.tasks.my_assigned_tasks.datatable_get', ]);
                Route::post('fullcalendar_get', ['uses' => 'MyAssignedTaskController@fullcalendar_get', 'as' => 'ltm.clients.tasks.my_assigned_tasks.fullcalendar_get', ]);
            });
            Route::group(['prefix' => 'my_tasks', ], function()
            {
                Route::get('/', ['uses' => 'MyTaskController@index', 'as' => 'ltm.clients.tasks.my_tasks.index', ]);
                Route::post('datatable_get', ['uses' => 'MyTaskController@datatable_get', 'as' => 'ltm.clients.tasks.my_tasks.datatable_get', ]);
                Route::post('fullcalendar_get', ['uses' => 'MyTaskController@fullcalendar_get', 'as' => 'ltm.clients.tasks.my_tasks.fullcalendar_get', ]);
                Route::post('action', ['uses' => 'MyTaskController@action', 'as' => 'ltm.clients.tasks.my_tasks.action', ]);
                Route::post('save_track', ['uses' => 'MyTaskController@save_track', 'as' => 'ltm.clients.tasks.my_tasks.save_track', ]);
                Route::post('save_timeout', ['uses' => 'MyTaskController@save_timeout', 'as' => 'ltm.clients.tasks.my_tasks.save_timeout', ]);
            });
            Route::group(['prefix' => 'my_transcript_tasks', ], function()
            {
                Route::get('/', ['uses' => 'MyTranscriptTaskController@index', 'as' => 'ltm.clients.tasks.my_transcript_tasks.index', ]);
                Route::post('datatable_get', ['uses' => 'MyTranscriptTaskController@datatable_get', 'as' => 'ltm.clients.tasks.my_transcript_tasks.datatable_get', ]);
                Route::post('datatable_get_trash', ['uses' => 'MyTranscriptTaskController@datatable_get_trash', 'as' => 'ltm.clients.tasks.my_transcript_tasks_trash.datatable_get_trash', ]);
                Route::post('fullcalendar_get', ['uses' => 'MyTranscriptTaskController@fullcalendar_get', 'as' => 'ltm.clients.tasks.my_transcript_tasks_trash.fullcalendar_get', ]);
                Route::post('trash', ['uses' => 'MyTranscriptTaskController@trash', 'as' => 'ltm.clients.tasks.my_transcript_tasks_trash.trash', ]);
                Route::post('restore', ['uses' => 'MyTranscriptTaskController@restore', 'as' => 'ltm.clients.tasks.my_transcript_tasks_trash.restore', ]);
                Route::post('delete', ['uses' => 'MyTranscriptTaskController@delete', 'as' => 'ltm.clients.tasks.my_transcript_tasks_trash.delete', ]);
            });
            Route::group(['prefix' => 'task', ], function()
            {
                Route::post('add', ['uses' => 'TaskController@add', 'as' => 'ltm.clients.tasks.task.add', ]);
                Route::post('integrate', ['uses' => 'TaskController@integrate', 'as' => 'ltm.clients.tasks.task.integrate', ]);
            });
        });
    });

    Route::group(['prefix' => 'backend', 'namespace' => 'Backend'], function()
    {
        Route::get('/', [ 'as' => 'backend.dashboard', 'uses' => 'DashboardController@index']);
        Route::group(['prefix' => 'subjects','namespace' => 'Subjects' ], function()
        {
            Route::get('/', ['as' => 'ltm.backend.subjects.index', 'uses' => 'SubjectController@index']);
            Route::post('getSubjects', ['as' => 'ltm.backend.subjects.getSubjects', 'uses' => 'SubjectController@getSubjects']);
            Route::post('getSubjectsTree', ['as' => 'ltm.backend.subjects.getSubjectsTree', 'uses' => 'SubjectController@getSubjectsTree']);
            Route::post('getSubject', ['as' => 'ltm.backend.subjects.getSubject', 'uses' => 'SubjectController@getSubject']);
            Route::post('store', ['as' => 'ltm.backend.subjects.store', 'uses' => 'SubjectController@store']);
            Route::post('update', ['as' => 'ltm.backend.subjects.update', 'uses' => 'SubjectController@update']);
            Route::post('destroy', ['as' => 'ltm.backend.subjects.destroy', 'uses' => 'SubjectController@destroy']);
            Route::post('setOrder', ['as' => 'ltm.backend.subjects.setOrder', 'uses' => 'SubjectController@setOrder']);
            Route::post('add_subject/{id?}', ['uses' => 'SubjectController@add_subject', 'as' => 'ltm.backend.subjects.add_subject', ]);
            Route::post('add_subject_setting', ['uses' => 'SubjectController@add_subject_setting', 'as' => 'ltm.backend.subjects.add_subject_setting', ]);
            Route::post('save_order', ['as' => 'ltm.backend.subjects.save_order', 'uses' => 'SubjectController@save_order']);
            Route::post('test_get_data', ['as' => 'ltm.backend.subjects.test_get_data','uses' => 'SubjectController@test_get_data' ]);
        });
        Route::group(['prefix' => 'settings','namespace' => 'Settings' ], function()
        {
            Route::get('/', ['as' => 'ltm.backend.settings.index', 'uses' => 'SettingController@index']);
            Route::post('store', ['as' => 'ltm.backend.settings.store', 'uses' => 'SettingController@store']);
            Route::post('store_recive', ['as' => 'ltm.backend.settings.store_recive', 'uses' => 'SettingController@store_recive']);
        });
        Route::group(['prefix' => 'templates','namespace' => 'Templates' ], function()
        {
            Route::get('/', [ 'as' => 'ltm.backend.templates.index', 'uses' => 'TemplateController@index']);
            Route::post('save_management_template', [ 'as' => 'ltm.backend.templates.save_management_template', 'uses' => 'TemplateController@save_management_template']);
            Route::post('save_user_template', [ 'as' => 'ltm.backend.templates.save_user_template', 'uses' => 'TemplateController@save_user_template']);
        });
        Route::group(['prefix' => 'users','namespace' => 'Users' ], function()
        {
            Route::get('/', [ 'as' => 'ltm.backend.users.index', 'uses' => 'UserController@index']);
            Route::post('get_users', ['as' => 'ltm.backend.users.get_users', 'uses' => 'UserController@get_users']);
            Route::post('save_user', ['as' => 'ltm.backend.users.save_user', 'uses' => 'UserController@save_user']);
            Route::post('edit_user', ['as' => 'ltm.backend.users.edit_user', 'uses' => 'UserController@edit_user']);
            Route::post('view_user', ['as' => 'ltm.backend.users.view_user', 'uses' => 'UserController@view_user']);
        });
    });


    /*
     * auto_complete routes
     *
     */
    Route::group(['prefix' => 'auto_complete', ], function()
    {
        Route::group(['prefix' => 'common', ], function()
        {
            Route::post('forms', ['as' => 'ltm.auto_complete.forms', 'uses' => 'AutoCompleteController@forms', ]);
            Route::post('keywords', ['as' => 'ltm.auto_complete.keywords', 'uses' => 'AutoCompleteController@keywords', ]);
            Route::post('subjects', ['as' => 'ltm.auto_complete.subjects', 'uses' => 'AutoCompleteController@subjects', ]);
            Route::post('users', ['as' => 'ltm.auto_complete.users', 'uses' => 'AutoCompleteController@users', ]);
        });
    });
});
