<?php

namespace Hamahang\LTM\Requests\Clients\Tasks\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class Client_Response_Request extends FormRequest
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
            'description' => 'required'
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
            'track_description.required' => 'توضیحات الزامی است',
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
