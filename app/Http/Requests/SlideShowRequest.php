<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SlideShowRequest extends Request
{
    public function __construct()
    {

    }

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
        $data = array();
        $data['title'] = 'required';
        return $data;
    }

    public function messages()
    {
        $data = array();
        $data["title.required"] = 'Vui lòng nhập tiêu đề!';
        return $data;
    }
}