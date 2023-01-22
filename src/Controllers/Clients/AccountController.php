<?php

namespace Hamahang\LTM\Controllers\Clients;

use Hamahang\LTM\Controllers\Controller;
use App\UserCompanyInfo;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use DataTables;

class AccountController extends Controller
{

    public function dashboardIndex()
    {
        $user = config('laravel_task_manager.user_model')::find(auth()->id());
        $my_tasks_count = $user->my_tasks->count();
        $my_tasks_count_new = $user->my_new_tasks->count();
        $my_assigned_tasks = $user->my_assigned_tasks->count();
        $my_transcript_tasks = $user->my_transcript_assignments->count();
        $counters =
        [
            'my_tasks' => $my_tasks_count,
            'my_tasks_new' => $my_tasks_count_new,
            'my_assigned_tasks' => $my_assigned_tasks,
            'my_transcript_tasks' => $my_transcript_tasks,
        ];
        return view('laravel_task_manager::clients.account.dashboard_index')->with(compact('counters'));
    }

    public function profileIndex()
    {
        $companies = auth()->user()->companies[0];
        return view('laravel_task_manager::clients.profile.profile_index', compact('companies'));
    }

    public function getRequests(Request $request)
    {
        if ((int)$request->process_id > 0)
        {
            $requests = SysRequest::where('process_id', $request->process_id)
                ->where('user_id', auth()->id())
                ->with('process')
                ->select('sys_requests.*');
        }
        else
        {
            $requests = SysRequest::where('user_id', auth()->id())
                ->with('process')
                ->select('sys_requests.*');
        }

        return Datatables::eloquent($requests)
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->addColumn('title', function ($data)
            {
                $all_forms = ltm_ConvertNumbersEntoFa($data->forms()->where('type', '1')->count());
                $done_forms = ltm_ConvertNumbersEntoFa($data->SysRequestLevels()->where('is_confirmed_by_clients', '1')->count());
                $next_form_url = $data->next_form_url;
                if ($next_form_url)
                {
                    return '<a href="' . $next_form_url . '">' . $data->process->title . ' (' . $done_forms . ' از ' . $all_forms . ')' . '</a>';
                }
                else
                {
                    return $data->process->title . ' (' . $all_forms . '/' . $done_forms . ')';
                }
            })
            ->editColumn('tracking_code', function ($data)
            {
                return ltm_ConvertNumbersEntoFa($data->tracking_code);
            })
            ->editColumn('demand_number', function ($data)
            {
                return ltm_ConvertNumbersEntoFa($data->demand_number);
            })
            ->addColumn('created_at_jalali', function ($data)
            {
                return $data->created_at_jalali;
            })
            ->addColumn('status', function ($data)
            {
                return $data->form_status;
            })
            ->rawColumns(['title', 'status'])
            ->make(true);
    }

/*    public function editPersonalInfo(EditPersonalInfo_Request $request)
    {
        $user = auth()->user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->melli_code = $request->melli_code;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->save();

        $res =
            [
                'status' => "1",
                'status_type' => "success",
                'message' => [['title' => 'اطلاعات شخص با موفقیت ویرایش شد.']]
            ];

        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }

    public function editCompanyInfo(EditCompanyInfo_Request $request)
    {
        $user = UserCompanyInfo::where('user_id', auth()->id())->first();
        $user = $user ? $user : new UserCompanyInfo();
        $user->user_id = auth()->id();
        $user->national_id = $request->national_id;
        $user->company_type = $request->company_type;
        $user->company_name = $request->company_name;
        $user->company_register_number = $request->company_register_number;
        $user->company_register_date = $request->company_register_date;
        $user->company_postal_code = $request->company_postal_code;
        $user->company_address = $request->company_address;
        $user->company_phone = $request->company_phone;
        $user->company_city_id = $request->company_address_province_city;
        $user->save();

        $res =
            [
                'status' => "1",
                'status_type' => "success",
                'message' => [['title' => 'اطلاعات شرکت با موفقیت ویرایش شد.']]
            ];

        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }

    public function changePassword(ChangePassword_Request $request)
    {
        $user = auth()->user();
        $user->password = bcrypt($request->password);
        $user->save();

        $res =
            [
                'status' => "1",
                'status_type' => "success",
                'message' => [['title' => 'تغییر کلمه عبور با موفقیت انجام شد.']]
            ];

        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );

    }

    public function changeAvatar(ChangeAvatar_Request $request)
    {
        $upload = HFM_Upload($request->file('user_avatar'), 'Avatars');
        $user = auth()->user();
        $user->avatar_file_id = $upload['ID'];
        $user->save();

        $res =
            [
                'status' => "1",
                'status_type' => "success",
                'message' => ['تصویر شاخص با موفقیت ذخیره شد.']
            ];

        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }*/

    public function removeAvatar()
    {
        $user = auth()->user();
        $user->avatar_file_id = null;
        $user->save();

        $res =
            [
                'status' => "1",
                'status_type' => "success",
                'message' => ['تصویر شاخص با موفقیت حذف شد.']
            ];

        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }
}
