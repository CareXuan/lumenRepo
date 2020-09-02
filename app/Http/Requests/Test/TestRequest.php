<?php


namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class TestRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'type'   => [
                'required',
                Rule::in(['all', 'hour'])
            ]
        ];
    }

    public function messages()
    {
        return [
            'type.required'   => '请输入榜单类型',
        ];
    }
}