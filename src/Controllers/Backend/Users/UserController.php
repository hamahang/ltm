<?php

namespace Hamahang\LTM\Controllers\Backend\Users;

use Validator;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('laravel_task_manager::backend.users.index');
    }

    public function get_users(Request $request)
    {
        $users = config('laravel_task_manager.user_model')::select('id', 'email', 'user_type', 'melli_code', 'first_name', 'last_name', 'mobile', 'address', 'avatar_file_id', 'postal_code', 'is_active');
        return Datatables::eloquent($users)
            ->editColumn('id', function ($users)
            {
                return ltm_enCode($users->id);
            })
            ->make(true);
    }

    public function view_user(Request $request)
    {
        $user = config('laravel_task_manager.user_model')::where('id', ltm_deCode($request->item_id))->first();
        if ($user)
        {
            $result =
                [
                    'success' => true,
                    'user' => $user,
                ];
        }
        else
        {
            $result =
                [
                    'success' => false,
                    'message' => [["title" => ["ذخیره اطلاعات"], "items" => ["مشکل در ذخیره اطلاعات."]]]
                ];
        }
        return response()->json($result, 200)->withHeaders(['Content-Type' => 'json', 'charset' => 'utf-8']);

    }

    public function save_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_type' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'melli_code' => 'required',
            'mobile' => 'required',
            'postal_code' => 'required',
            'address' => 'required',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return response()->json($result);
        }
        else
        {
            $user_model = config('laravel_task_manager.user_model') ;
            $user = new $user_model ;
            $user->user_type = $request->user_type;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->melli_code = $request->melli_code;
            $user->mobile = $request->mobile;
            $user->postal_code = $request->postal_code;
            $user->address = $request->address;
            $user->created_by = '1';

            if ($user->save())
            {
                $result =
                    [
                        'success' => true,
                        'message' => [["title" => ["ذخیره اطلاعات"], "items" => ["اطلاعات کاربر با موفقیت ذخیره شد"]]],
                    ];
            }
            else
            {
                $result =
                    [
                        'success' => false,
                        'message' => [["title" => ["ذخیره اطلاعات"], "items" => ["مشکل در ذخیره اطلاعات."]]]
                    ];
            }
            return response()->json($result, 200)->withHeaders(['Content-Type' => 'json', 'charset' => 'utf-8']);

        }
    }

    public function edit_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_type' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'melli_code' => 'required',
            'mobile' => 'required',
            'postal_code' => 'required',
            'address' => 'required',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return response()->json($result);
        }
        else
        {
            $user = config('laravel_task_manager.user_model')::where('id',$request->item_id)->first();
            $user->user_type = $request->user_type;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->melli_code = $request->melli_code;
            $user->mobile = $request->mobile;
            $user->postal_code = $request->postal_code;
            $user->address = $request->address;
            $user->created_by = '1';
            if ($user->save())
            {
                $result =
                    [
                        'success' => true,
                        'message' => [["title" => ["ویرایش اطلاعات"], "items" => ["اطلاعات کاربر با موفقیت ویرایش شد"]]],
                    ];
            }
            else
            {
                $result =
                    [
                        'success' => false,
                        'message' => [["title" => ["ویرایش اطلاعات"], "items" => ["مشکل در ویرایش اطلاعات."]]]
                    ];
            }
            return response()->json($result, 200)->withHeaders(['Content-Type' => 'json', 'charset' => 'utf-8']);
        }
    }

}
