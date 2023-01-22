<?php

namespace Hamahang\LTM\Controllers\Backend\Templates;

use Hamahang\LTM\Models\TemplateSetting;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class TemplateController extends Controller
{
    public function index()
    {
        $option_single = ['size_file' => 100, 'max_file_number' => 1, 'true_file_extension' => ['png','jpg']];
        $logo_manager = LFM_CreateModalFileManager('logo_manager',$option_single , 'insert','showLogoManager',false,'لوگو قالب',false,'انتخاب فایل');
        $logo_user = LFM_CreateModalFileManager('logo_user',$option_single , 'insert','showLogoUser',false,'لوگو قالب',false,'انتخاب فایل');
        $template_satting_manager = TemplateSetting::where('type','1')->first();
        $template_satting_user = TemplateSetting::where('type','2')->first();
        $logo_manager_view = null ;
        $logo_user_view = null ;
        if($template_satting_manager and $template_satting_user){
            $logo_manager_view = LFM_loadSingleFile($template_satting_manager,'img_id','logo_manager','options');
            $logo_user_view = LFM_loadSingleFile($template_satting_user,'img_id','logo_user','options');
            //$logo_user = LFM_CreateModalFileManager('logo_user',$option_single , 'insert','showLogoUser',false,'لوگو قالب',false,'انتخاب فایل');
        }

        return view('laravel_task_manager::backend.templates.index',compact('logo_manager','logo_user','logo_manager_view','logo_user_view','template_satting','template_satting_manager','template_satting_user'));
    }

    public function save_management_template(Request $request)
    {
        $input = $request->all();
        $rules = [
            'text_footer' => 'required',
            'theme_nav' => 'required',
            'theme_sidebar' => 'required',
        ];
        $messages = [
            'text_footer.required' => 'فیلد پاورقی قالب الزامی است',
        ];
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails())
        {
            $error = ltm_validation_error_to_api_json($validator->errors());
            $res =
                [
                    'success' => false,
                    'error' => $error
                ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'json', 'charset' => 'utf-8']);
        }
        else
        {
            $template_setting_management =  TemplateSetting::where('type','1')->first();
            if($template_setting_management){
                $template_setting_management->text_footer = $request->text_footer;
                $template_setting_management->theme_nav = $request->theme_nav;
                $template_setting_management->theme_sidebar = $request->theme_sidebar;
                $template_setting_management->created_by = '1';
                if( $template_setting_management->save()){
                    $res = LFM_SaveSingleFile($template_setting_management,'img_id','logo_manager','options');
                    if($res){
                        $result['message'][] = "تنظیمات قالب با موفقیت انجام شد.";
                        $result['success'] = true;
                    }else{
                        $result =
                            [
                                'success' => false,
                                'error' => array("مشکل در ذخیره اطلاعات.")
                            ];
                    }
                    return response()->json($result, 200)->withHeaders(['Content-Type' => 'json', 'charset' => 'utf-8']);
                }
            }
        }
    }

    public function save_user_template(Request $request)
    {
        $input = $request->all();
        $rules = [
            'text_footer_user' => 'required',
            'theme_nav_user' => 'required',
            'theme_sidebar_user' => 'required',
        ];
        $messages = [
            'text_footer_user.required' => 'فیلد پاورقی قالب الزامی است',
        ];
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails())
        {
            $error = ltm_validation_error_to_api_json($validator->errors());
            $res =
                [
                    'success' => false,
                    'error' => $error
                ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'json', 'charset' => 'utf-8']);
        }
        else
        {
            $template_setting_management =  TemplateSetting::where('type','2')->first();
            if($template_setting_management){
                $template_setting_management->text_footer = $request->text_footer_user;
                $template_setting_management->theme_nav = $request->theme_nav_user;
                $template_setting_management->type = '2';
                $template_setting_management->theme_sidebar = $request->theme_sidebar_user;
                $template_setting_management->created_by = '1';
                if( $template_setting_management->save()){
                    $res= LFM_SaveSingleFile($template_setting_management,'img_id','logo_user','options');
                    if($res){
                        $result['message'][] = "تنظیمات قالب با موفقیت انجام شد.";
                        $result['success'] = true;
                        return response()->json($result, 200)->withHeaders(['Content-Type' => 'json', 'charset' => 'utf-8']);
                    }
                }
            }
        }
    }
}
