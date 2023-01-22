<?php

namespace Hamahang\LTM\Controllers;

use Hamahang\LTM\Models\Form;
use Hamahang\LTM\Models\Subject;
use Hamahang\LTM\Models\Keyword;
use Hamahang\LTM\Models\ProvinceCity\Shahrak;
use Hamahang\LTM\Models\ProvinceCity\Town;
use Hamahang\LTM\Models\ProvinceCity\Village;
use Hamahang\LTM\Models\System\SysAgreement;
use Hamahang\LTM\Models\System\SysProcess;
use DB;
use Illuminate\Http\Request;
use Hamahang\LTM\Models\ProvinceCity\City;
use Hamahang\LTM\Models\ProvinceCity\Province;
use Hamahang\LTM\Models\ProvinceCity\Bakhsh;
use Hamahang\LTM\Controllers\Controller;


class AutoCompleteController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forms(Request $request)
    {
        $x = $request->term;
        if ($x['term'] == '...')
        {
            $data = Form::select('id', 'title as text')->where('is_active', '1');
        } else
        {
            $data = Form::select('id', 'title as text')->where('is_active', '1')->where('title', 'LIKE', '%' . $x['term'] . "%");
        }
        $data = $data->get();
        $data = array('results' => $data);
        return response()->json($data);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function keywords(Request $request)
    {
        $x = $request->term;
        if ($x['term'] == '...')
        {
            $data = Keyword::select('id', 'title as text')->where('is_active', '1');
        } else
        {
            $data = Keyword::select('id', 'title as text')->where('is_active', '1')->where('title', 'LIKE', '%' . $x['term'] . "%");
        }
        $data = $data->get();
        $data = array('results' => $data);
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subjects(Request $request)
    {
        $x = $request->term;
        if (function_exists(config('laravel_task_manager.task_assigments_subject_function_name')))
        {
            $data = config('laravel_task_manager.task_assigments_subject_function_name')() ;
        }
        else
        {
            $data = Subject::select('id', 'title as text')->where('is_active', '1') ;
        }
        if ($x['term'] != '...')
        {
            $data = $data->where('title', 'LIKE', '%' . $x['term'] . "%");
        }
        $data = $data->get();
        $data = array('results' => $data);
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function users(Request $request)
    {
        $x = $request->term;
        $data = config('laravel_task_manager.task_assigments_users_id_function_name')();

        if ($x['term'] != '...')
        {
            $data =$data
                ->where("username", "LIKE", "%" . $x['term'] . "%")
                ->Orwhere("first_name", "LIKE", "%" . $x['term'] . "%")
                ->Orwhere("last_name", "LIKE", "%" . $x['term'] . "%")
                ->Orwhere("email", "LIKE", "%" . $x['term'] . "%")

            ;
        }
        $data = $data->whereRoleIs('task_creator')->get();
        $data = array('results' => $data);
        return response()->json($data);
    }
}
