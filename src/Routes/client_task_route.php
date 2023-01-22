<?php

if (config('laravel_task_manager.task_show_client_route_function_name')())
{
    Route::group(['prefix' => config('laravel_task_manager.client_ltm_route_prefix'), 'namespace' => 'Hamahang\LTM\Controllers', 'middleware' => config('laravel_task_manager.backend_ltm_middlewares')], function () {
        Route::group(['prefix' => 'clients', 'namespace' => 'Clients'], function()
        {
            Route::group(['prefix' => 'tasks', 'namespace' => 'Tasks', ], function()
            {
                Route::group(['prefix' => 'panels', 'namespace' => 'Panels', ], function()
                {
                    Route::post('/jsPanelTask', ['as' => 'ltm.clients.tasks.panels.jspanel', 'uses' => 'ClientTaskController@JsPanelTask']);
                    Route::post('/addTask', ['as' => 'ltm.clients.tasks.panels.add', 'uses' => 'ClientTaskController@addTask']);
                    Route::post('/getDatatable', ['as' => 'ltm.clients.tasks.panels.get_datatable', 'uses' => 'ClientTaskController@getDatatable']);
                    Route::post('/getTrackingView', ['as' => 'ltm.clients.tasks.panels.get_tracking_view', 'uses' => 'ClientTaskController@getTrackingView']);
                    Route::post('/sendClientResponse', ['as' => 'ltm.clients.tasks.panels.send_response', 'uses' => 'ClientTaskController@sendClientResponse']);
                });
            });
        });
    });
}
