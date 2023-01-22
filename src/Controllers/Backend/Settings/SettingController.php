<?php

namespace Hamahang\LTM\Controllers\Backend\Settings;

use DB ;
use Hamahang\LTM\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SettingController extends Controller
{

    public function index()
    {
        $setting = auth()->user()->ltm_setting ;
        return view('laravel_task_manager::backend.settings.index',compact('setting')) ;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $user_id = auth()->id() ;
            $user = auth()->user() ;
            if( $user->ltm_setting)
            {
                $setting = $user->ltm_setting ;
            }
            else
            {
                $setting = new Setting() ;
                $setting->user_id =$user_id ;
            }
            $setting->is_acive_email = $request->is_acive_email ;
            $setting->is_acive_sms = $request->is_acive_sms ;
            $setting->is_acive_messenger = $request->is_acive_messenger ;
            $setting->responsible_email = $request->responsible_email ;
            $setting->responsible_sms = $request->responsible_sms ;
            $setting->responsible_messenger = $request->responsible_messenger ;
            $setting->transcript_email = $request->transcript_email ;
            $setting->transcript_sms = $request->transcript_sms ;
            $setting->transcript_messenger = $request->transcript_messenger ;
            $setting->recive_email_is_active = $request->recive_email_is_active ;
            $setting->recive_sms_is_active = $request->recive_sms_is_active ;
            $setting->recive_messenger_is_active = $request->recive_messenger_is_active ;
            $setting->save() ;

            $res = [
                'success' => true,
                'title'   => "ذخیره تنظیمات اطلاع رسانی",
                'message' => 'تنظیمات اطلاع رسانی با موفقیت ذخیره شد .'
            ];
            DB::commit();

            return $res;
        } catch (\Exception $e)
        {
            log_exeption($e);
            DB::rollback();
            if (in_array($request->getClientIp(), ['89.165.122.115', '185.57.167.118', '127.0.0.1']))
            {
                dd($e);
            }
            $res =
                [
                    'success' => false,
                    'status'  => "-1",
                    'message' => [['title' => 'خطا درثبت اطلاعات:', 'items' => ['در ثبت اطلاعات خطا روی داده است لطفا دوباره سعی کنید', 'درصورت تکرار این خطا لطفا با مدیریت تماس حاصل فرمایید.']]]
                ];

            return response()->json($res);
        }
    }

    public function store_recive(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $user_id = auth()->id() ;
            $user = auth()->user() ;
            if( $user->ltm_setting)
            {
                $setting = $user->ltm_setting ;
            }
            else
            {
                $setting = new Setting() ;
                $setting->user_id =$user_id ;
            }
            $setting->recive_email_is_active = $request->recive_email_is_active ;
            $setting->recive_sms_is_active = $request->recive_sms_is_active ;
            $setting->recive_messenger_is_active = $request->recive_messenger_is_active ;
            $setting->save() ;
            $res =
                [
                    'success' => true,
                    'title'   => "ذخیره تنظیمات دریافت",
                    'message' => 'تنظیمات دریافت اطلاع رسانی با موفقیت ذخیره شد .'
                ];
            DB::commit();

            return response()->json($res);
        } catch (\Exception $e)
        {
            log_exeption($e);
            DB::rollback();
            if (in_array($request->getClientIp(), ['89.165.122.115', '185.57.167.118', '127.0.0.1']))
            {
                dd($e);
            }
            $res =
                [
                    'success' => false,
                    'status'  => "-1",
                    'message' => [['title' => 'خطا درثبت اطلاعات:', 'items' => ['در ثبت اطلاعات خطا روی داده است لطفا دوباره سعی کنید', 'درصورت تکرار این خطا لطفا با مدیریت تماس حاصل فرمایید.']]]
                ];

            return response()->json($res);
        }
    }
}
