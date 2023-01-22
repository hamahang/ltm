<?php

namespace Hamahang\LTM\Controllers\Backend\Subjects;

use GuzzleHttp\Client;
use Validator;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Hamahang\LTM\Models\Subject;
use Hamahang\LTM\Models\SubjectSetting;

class SubjectController extends Controller
{
    private function reOrderWorkGroupItems($parent_id)
    {
        $subjects = Subject::where('parent_id', $parent_id)->orderBy('order', 'asc')->get();
        $i = 1;
        foreach ($subjects as $subject)
        {
            $subject->order = $i++;
            $subject->save();
        }
        return $i;
    }

    private function file_no_list($subject_id,$row_id,$user_id =false)
    {
        $subject = Subject::find($subject_id);
        $SubjectSetting = SubjectSetting::where('subject_id',$subject->id)->where('type','1')->first();
        if($SubjectSetting){
            $form_params['report_id'] = $SubjectSetting->report_id;
            $form_params['token'] = $SubjectSetting->token;
            if(isset($request->row_id)){
                $form_params['conditions'] = json_encode(array($SubjectSetting->column_id => $row_id));
            }
            $temp=[];
            foreach(explode(',',$SubjectSetting->template_id) as $key=>$param){
                $temp= array_merge($temp,[$key => $param]);
            }
            $form_params['templates'] =json_encode($temp);
            $form_params['array'] = 'true';
            $form_params['template'] = 'true';
            $form_params['form_params'] = $form_params;
            // send data with guzzle
            $client = new Client();
            $response = $client->post($SubjectSetting->url, $form_params);
            $data = $response->getBody()->getContents();
            $bom = pack('H*', 'EFBBBF');
            $text = preg_replace("/^$bom/", '', $data);
            $data_decode = json_decode($text);
            if ($data_decode->status == '1')
            {
                if(isset($request->row_id)){
                    foreach($data_decode->items as $arr_param)
                    {
                        $array_data[] = $arr_param;
                    }
                }else{
                    $num = 0;
                    foreach($data_decode->data as $arr_param)
                    {
                        $text_concat='';

                        foreach($arr_param as $key=>$param){

                            if($key == $SubjectSetting->column_id){
                                $array_data[$num]['id'] = (int)$param;
                            }
                            if(in_array($key,explode(',',$SubjectSetting->column_concat))){
                                if($text_concat != ''){
                                    $text_concat .= ' _ '.$param;
                                }
                                else{
                                    $text_concat .= $param;
                                }
                            }
                        }
                        $array_data[$num]['text'] = $text_concat;
                        $num++;
                    }
                }
                $message['status'] = '1';
                $message['data'] = $array_data;
                return response()->json($message);
            }
            else
            {
                $message['status'] = '0';
                $message['data'] = 'امکان دریافت اطلاعات نمی باشد';
                return response()->json($message);
            }
        }
        else
        {
            $message['status'] = '0';
            $message['data'] = 'تنظیمات موضوع برای اتصال کامل نیست';
            return response()->json($message);
        }
    }

    public function index()
    {
        $subjects = Subject::all();
        $subjects_json = Subject::all('id AS key', 'code', 'title', 'background_color', 'text_color', 'parent_id');
        $subjects_json = json_decode($subjects_json, true);
        $tree = ltm_buildTree($subjects_json, 'parent_id', 0, 'key');
        return view('laravel_task_manager::backend.subjects.index')
            ->with('subjects', $subjects)
            ->with('json', json_encode($tree));
    }

    public function test_get_data(Request $request)
    {
        if (function_exists( config('laravel_task_manager.task_file_no_list')))
        {
            return config('laravel_task_manager.task_file_no_list')() ;
        }
        else
        {
            return $this->file_no_list($request->subject_id,$request->row_id);
        }
    }

    public function getSubjects(Request $request)
    {
        if (isset($request->subject_id))
        {
            $subjects = Subject::with('user')->with('parent')->where('parent_id', $request->subject_id);
        }
        else
        {
            $subjects = Subject::with('user')->with('parent');
        }
        return Datatables::eloquent($subjects)
            ->editColumn('id', function ($data)
            {
                return ltm_encode_ids([$data->id]);
            })
            ->addColumn('edit_access', function ($data)
            {

                return true;
            })
            ->addColumn('delete_access', function ($data)
            {
                return true;
            })
            ->make(true);
    }

    public function getSubjectsTree()
    {
        $subjects = Subject::all('id as key', 'title', 'parent_id');
        $subjects = json_decode($subjects, true);
        $tree = ltm_buildTree($subjects, 'parent_id', 0, 'key');
        return response()->json($tree);
    }

    public function getSubject(Request $request)
    {
        $id = ltm_decode_ids($request->input('id'), 0);
        $item = Subject::findOrFail($id);
        $item->id = ltm_encode_ids([$item->id]);
        $res['info'] = $item;
        return response()->json($res);
    }

    public function store(Request $request)
    {
        $messages =
        [
            'title.required' => 'فیلد نام الزامی است ',
        ];
        $validator = Validator::make($request->all(),
        [
            'code' => 'required|integer|min:100|max:999|unique:ltm_subjects',
            'title' => 'required',
        ], $messages);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return response()->json($result);
        } else
        {
            if ($request->input('subject_id'))
            {
                $subject = Subject::where('parent_id', $request->input('subject_id'))->orderBy('order', 'DESC')->first();
                if (!empty($subject))
                {
                    $order = $subject->order + 1;
                } else
                {
                    $order = 1;
                }
            } else
            {
                $order = 1;
            }
            $Subject_new = new Subject();
            $Subject_new->code = str_pad($request->input('code'), 3, '0', STR_PAD_LEFT);
            $Subject_new->title = $request->input('title');
            $Subject_new->background_color = $request->input('background_color');
            $Subject_new->text_color = $request->input('text_color');
            $Subject_new->parent_id = $request->input('subject_id');
            $Subject_new->order = $order;
            $Subject_new->is_active = '1';
            $Subject_new->created_by = '1';
            $Subject_new->save();
            $result['message'][] = trans('ltm_app.operation_is_success');
            $result['success'] = true;
            return response()->json($result);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return response()->json($result);
        }
        else
        {
            if ($request->input('subject_id'))
            {
                $subject = Subject::where('parent_id', $request->input('subject_id'))->orderBy('order', 'DESC')->first();
                if (!empty($subject))
                {
                    $order = $subject->order + 1;
                }
                else
                {
                    $order = 1;
                }
            }
            else
            {
                $order = 1;
            }
            $item_id = ltm_decode_ids($request->input('item_id'), 0);
            $Subject = Subject::find($item_id);
            //$Subject->code = $request->input('code');
            $Subject->title = $request->input('title');
            $Subject->background_color = $request->input('background_color');
            $Subject->text_color = $request->input('text_color');
            $Subject->order = $order;
            $Subject->parent_id = $request->input('subject_id');
            $Subject->created_by = '1';
            $Subject->save();
            $result['message'][] = trans('ltm_app.operation_is_success');
            $result['success'] = true;
            return response()->json($result);
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return response()->json($result);
        }
        else
        {
            $item_id = ltm_decode_ids($request->input('item_id'), 0);
            Subject::destroy($item_id);
            $result['message'][] = trans('ltm_app.operation_is_success');
            $result['success'] = true;
            return response()->json($result);
        }
    }

    public function setOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'type' => 'required',
            'value' => 'required|int',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return response()->json($result);
        }
        else
        {
            set_item_order('Hamahang\LTM\Models\Subject',
                $request->input('id'),
                $request->input('order_step'),
                $request->input('type'),
                $request->input('value'), 1);

            $result['message'][] = trans('ltm_app.operation_is_success');
            $result['success'] = true;
            return response()->json($result);
        }
    }

    public function add_subject($id)
    {
        $Subject = Subject::where('id', ltm_decode_ids($id, 0))->first();
        //get list subjects
        $SubjectSettingGet = SubjectSetting::where('subject_id', ltm_decode_ids($id, 0))->where('type', '1')->first();
        //show subject
        $SubjectSettingShow = SubjectSetting::where('subject_id', ltm_decode_ids($id, 0))->where('type', '2')->first();
        $content = view('laravel_task_manager::backend.subjects.subject_settings.content')->with('Subject', $Subject)->with('SubjectSettingGet', $SubjectSettingGet)->with('SubjectSettingShow', $SubjectSettingShow)->render();
        $header = view('laravel_task_manager::backend.subjects.subject_settings.header')->with('Subject', $Subject)->render();
        $footer = view('laravel_task_manager::backend.subjects.subject_settings.footer')->render();
        $r = json_encode(['header' => $header, 'content' => $content, 'footer' => $footer,]);
        return $r;

    }

    public function add_subject_setting(Request $request)
    {
        $messages = [
            'subject_id.required' => 'موضوع نامعتبر است ',
            'url.required' => 'فیلد آدرس الزامی است ',
            'report.required' => 'فیلد کد گزارش الزامی است ',
            'template.required' => 'فیلد کد قالب الزامی است ',
            'token.required' => 'فیلد توکن الزامی است ',
            'column.required' => 'فیلد شماره فیلد الزامی است ',
            'url_get_list.required' => 'فیلد آدرس الزامی است ',
            'report_get_list.required' => 'فیلد کد گزارش الزامی است ',
            'template_get_list.required' => 'فیلد کد قالب الزامی است ',
            'token_get_list.required' => 'فیلد توکن الزامی است ',
            'column_get_list.required' => 'فیلد شماره فیلد الزامی است ',
            'column_concat_get_list.required' => 'فیلد ترکیب شماره فیلد ها الزامی است ',
        ];
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required',
            'url' => 'required',
            'token' => 'required',
            'report' => 'required',
            'template' => 'required',
            'column' => 'required',
            'url_get_list' => 'required',
            'token_get_list' => 'required',
            'report_get_list' => 'required',
            'template_get_list' => 'required',
            'column_get_list' => 'required',
            'column_concat_get_list' => 'required',
        ], $messages);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return response()->json($result);
        }
        else
        {
            //type=1 subjects list
            $SubjectSetting = SubjectSetting::where('subject_id', ltm_decode_ids($request->subject_id, 0))->where('type', '1')->first();
            if (!$SubjectSetting)
            {
                $SubjectSetting = new SubjectSetting();
            }
            $SubjectSetting->subject_id = ltm_decode_ids($request->subject_id, 0);
            $SubjectSetting->url = $request->url_get_list;
            $SubjectSetting->token = $request->token_get_list;
            $SubjectSetting->report_id = $request->report_get_list;
            $SubjectSetting->template_id = implode(',', $request->template_get_list);
            $SubjectSetting->column_id = $request->column_get_list;
            $SubjectSetting->column_concat = implode(',', $request->column_concat_get_list);
            $SubjectSetting->type = '1';
            $SubjectSetting->created_by = '1';/*auth()->id()*/;
            $SubjectSetting->save();

            //type=2 show subject
            $SubjectSetting2 = SubjectSetting::where('subject_id', ltm_decode_ids($request->subject_id, 0))->where('type', '2')->first();
            if (!$SubjectSetting2)
            {
                $SubjectSetting2 = new SubjectSetting();
            }
            $SubjectSetting2->subject_id = ltm_decode_ids($request->subject_id, 0);
            $SubjectSetting2->url = $request->url;
            $SubjectSetting2->token = $request->token;
            $SubjectSetting2->report_id = $request->report;
            $SubjectSetting2->template_id = implode(',', $request->template);
            $SubjectSetting2->column_id = $request->column;
            $SubjectSetting2->type = '2';
            $SubjectSetting2->created_by = '1';/*auth()->id()*/;
            $SubjectSetting2->save();

            $result['message'][] = 'تنظیمات با موفقیت ثبت شد';
            $result['success'] = true;
            return response()->json($result);
        }
    }

    public function save_order(Request $request)
    {
        $input = $request->all();
        $rules = [
            'parent_id' => 'required',
            'id' => 'required',
            'order_type' => 'required',
        ];
        $messages = [
            'parent_id.required' => 'والد انتخاب نشده است.',
            'id.required' => ' موضوع انتخاب نشده است.',
            'order_type.required' => 'نوع تغییر مشخص نشده است. ',
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
            $this->reOrderWorkGroupItems($request->parent_id);
            $subject = Subject::find(ltm_decode_ids($request->id, 0));
            $order = $subject->order;
            if ($request->order_type == 'increase')
            {
                $max_order = 1;
                $max_item = Subject::where('parent_id', $subject->parent_id)->orderBy('order', 'desc')->first();
                if ($max_item)
                {
                    $max_order = $max_item->order;
                }
                if ($order < $max_order)
                {
                    $nextSubject = Subject::where('parent_id', $subject->parent_id)->where('order', $order + 1)->first();
                    if ($nextSubject)
                    {
                        $subject->order = $order + 1;
                        $subject->save();

                        /*save new order of next subject*/
                        $nextSubject->order = $order;
                        $nextSubject->save();
                    }
                }
            }
            elseif ($request->order_type == 'decrease')
            {
                if ($order > 1)
                {
                    $previousSubject = Subject::where('parent_id', $subject->parent_id)->where('order', $order - 1)->first();
                    if ($previousSubject)
                    {
                        $subject->order = $order - 1;
                        $subject->save();

                        /*save new order of previous subject*/
                        $previousSubject->order = $order;
                        $previousSubject->save();
                    }
                }
            }
            else
            {
                $result['error'][] = "متاسفانه با مشکل مواجه شد!";
                $result['success'] = false;
                return response()->json($result, 200)->withHeaders(['Content-Type' => 'json', 'charset' => 'utf-8']);
            }

            $result['message'][] = "با موفقیت انجام شد.";
            $result['success'] = true;
            return response()->json($result, 200)->withHeaders(['Content-Type' => 'json', 'charset' => 'utf-8']);
        }
    }
}
