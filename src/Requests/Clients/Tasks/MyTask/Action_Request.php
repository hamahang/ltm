<?php

namespace Hamahang\LTM\Requests\Clients\Tasks\MyTask;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Action_Request extends FormRequest
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
    public function rules()
    {
        $r =
        [
            // general
            'task_id' => 'required',
            // type: do
            'action_do_status' => 'required_if:action_type,1',
            'action_do_status_percent' => 'required_if:action_do_status,1|integer|min:0|max:100',
            'action_do_importance' => 'required_if:action_type,1',
            'action_do_immediate' => 'required_if:action_type,1',
            // type: transfer
            'action_transfer_user' => 'required_if:action_type,2',
            'action_transfer_transcripts_cc' => 'nullable|array',
            'action_transfer_transcripts_bcc' => 'nullable|array',
            // type: reject
            'action_reject_accept' => 'required_if:action_type,3',
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
            // general
            // type: do
            'action_do_status.*' => 'وضعیت الزامی است',
            'action_do_status_percent.*' => 'درصد پیشرفت الزامی و باید بین 0 تا 100 باشد',
            'action_do_importance.*' => 'اهمیت الزامی است',
            'action_do_immediate.*' => 'فوریت الزامی است',
            // type: transfer
            'action_transfer_user.*' => 'مسئول الزامی است',
            // type: reject
            'action_reject_accept.*' => 'پذیرش شرط "عدم توانایی انجام" الزامی است',
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
                    'title' => 'لطفا موارد زیر را بررسی نمایید:',
                    'items' => $api_errors,
                ],
            ],
        ];
        throw new HttpResponseException(response()->json($r, 200)->withHeaders(['content-type' => 'text/plain', 'charset' => 'utf-8']));
    }
}
