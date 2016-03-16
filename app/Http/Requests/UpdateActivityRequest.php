<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class UpdateActivityRequest extends FormRequest
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
        return [
            'title'       => 'required|min:3|max:255|regex:/^[(\x{4E00}-\x{9FA5})A-Za-z0-9\-,!@\.\(\)]+$/u',
            'thumbnail'   => 'mimes:jpeg,bmp,png',
            'location'    => 'required|min:3'
        ];
    }

    public function messages()
    {
        return [
            'title.required'      => '請務必填寫 文章標題 欄位',
            'title.min'           => '活動名稱 最少 :min 字元',
            'title.max'           => '活動名稱 最多 :max 字元',
            'title.regex'         => '活動名稱 請勿輸入空白或者特殊符號',
            'location.required'   => '請務必填寫 活動地點 欄位',
            'location.min'        => '活動地點 最少 :min 字元',
            'thumbnail.required'  => '請選擇圖片作為 活動縮圖',
            'thumbnail.mimes'     => '縮圖的型態請為: :values.',
        ];
    }
}
