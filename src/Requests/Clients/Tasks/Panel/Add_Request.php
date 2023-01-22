<?php

namespace Hamahang\LTM\Requests\Clients\Tasks\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class Add_Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $r =
        [
            'general_importance' => 'required|in:0,1',
            'general_immediate' => 'required|in:0,1',
            'general_title' => 'required',
            'general_subject_id' => 'required',
            'general_keywords' => 'nullable|array',
            //'general_file_no' => 'required',
        ];
        return $r;
    }

    /**
     * @return array
     */
    public function messages()
    {
        $r =
        [
            'general_type.required' => 'نوع الزامی است',
            'general_type.in' => 'نوع معتبر نیست',
            'general_importance.required' => 'اهمیت الزامی است',
            'general_importance.in' => 'اهمیت معتبر نیست',
            'general_immediate.required' => 'فوریت الزامی است',
            'general_immediate.in' => 'فوریت معتبر نیست',
            'general_title.required' => 'عنوان الزامی است',
            'general_subject_id.required' => 'موضوع الزامی است',
            'general_users.required' => 'مسئول یا مسئولین الزامی است',
            'general_users.array' => 'مسئول یا مسئولین معتبر نیست',
            'general_transcripts_cc.array' => 'رونوشت عمومی معتبر نیست',
            'general_transcripts_bcc.array' => 'رونوشت خصوصی معتبر نیست',
            'general_keywords.array' => 'کلیدواژه‌ها معتبر نیست',
            'general_file_no.required' => 'شماره پرونده الزامی است',
            'general_deadline.required' => 'مهلت انجام الزامی است',
            'general_deadline.in' => 'مهلت انجام معتبر نیست',
            'general_deadline_from.required_if' => 'زمان مقرر الزامی است',
            'general_deadline_from.in' => 'زمان مقرر معتبر نیست',
            'general_deadline_from_date.required_if' => 'تاریخ شروع در زمان مقرر الزامی است',
            'general_deadline_from_date.jalali_date' => 'تاریخ شروع در زمان مقرر معتبر نیست',
            'general_deadline_from_date.jalali_date_after' => 'تاریخ شروع در زمان مقرر باید از امروز آغاز شود',
            'general_deadline_from_time.required_if' => 'ساعت در زمان مقرر الزامی است',
            'general_deadline_from_time.date_format' => 'ساعت معتبر نیست (به شکل دقیقه:ساعت و بدون ثانیه صحیح است)',
            'general_deadline_to.required_if' => 'زمان مقرر الزامی است',
            'general_deadline_to.in' => 'زمان مقرر معتبر نیست',
            'general_deadline_to_date.required_if' => 'تاریخ پایان در زمان مقرر الزامی است',
            'general_deadline_to_date.jalali_date' => 'تاریخ پایان در زمان مقرر معتبر نیست',
            'general_deadline_to_date.jalali_date_after_or_equal' => 'تاریخ پایان در زمان مقرر باید برابر یا بعد از تاریخ شروع باشد',
            'general_deadline_to_time.required_if' => 'ساعت در زمان مقرر الزامی است',
            'general_deadline_to_time.date_format' => 'ساعت معتبر نیست (به شکل دقیقه:ساعت و بدون ثانیه صحیح است.)',
            'general_deadline_to_time.after' => 'ساعت پایان باید بعد از ساعت شروع باشد',
            'general_deadline_to_day.required_if' => 'تعداد روز مدت معتبر نیست',
            'general_deadline_to_hourmin.required_if' => 'ساعت مدت معتبر نیست',
        ];
        return $r;
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        $api_errors = ltm_validation_error_to_api_json($validator->errors());
        $r =
        [
            'status' => '-1',
            'status_type' => 'error',
            'errors' => $api_errors,
            'reload' => true,
            'message' =>
            [
                [
                    'title' => 'لطفاً موارد زیر را بررسی نمایید',
                    'items' => $api_errors,
                ],
            ],
        ];
        throw new HttpResponseException(response()->json($r, 200)->withHeaders(['content-type' => 'text/plain', 'charset' => 'utf-8']));
    }
}
