<?php

namespace Hamahang\LTM\Controllers\Backend;

use Illuminate\Routing\Controller;

class DashboardController extends Controller
{

    public function index()
    {
        //$subjects = Subject::all();
        return view('laravel_task_manager::backend.dashboard');
    }

}
