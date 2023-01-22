<?php

namespace Hamahang\LTM\Requests\Clients\Tasks\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class PanelTask_Request extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $role = [

        ];
        $roles = array_merge($role);
        return $roles;
    }

    protected function failedValidation(Validator $validator)
    {
        $api_errors = validation_error_to_api_json($validator->errors());
        $res =
            [
                'status' => "-1",
                'errors' => $api_errors,
                'message' => [['title' => 'لطفا موارد زیر را بررسی نمایید:', 'items' => $api_errors]]
            ];
        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }

    public function messages()
    {
        return [
            'request_id.unique'=>trans('construction/forms/cons_104.request_id_unique'),
            'request_id.required' => trans('construction/forms/cons_101.edit_id_required'),
            'request_id.exist_user_request' => trans('construction/forms/cons_101.edit_id_required'),
        ];
    }
}
