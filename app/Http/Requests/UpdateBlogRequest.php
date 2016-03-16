<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class UpdateBlogRequest extends FormRequest
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
          // unique:articles,title| 無法實作
            'title'       => 'required|min:3|max:255|regex:/^[(\x{4E00}-\x{9FA5})A-Za-z0-9\-,!@\.\(\)]+$/u',
            'created_at'  => 'required|date',
            'thumbnail'   => 'mimes:jpeg,bmp,png',
        ];
    }

    public function messages()
    {
        return [
            'title.required'      => '請務必填寫 文章標題 欄位',
            'title.min'           => '文章標題 最少 :min 字元',
            'title.max'           => '文章標題 最多 :max 字元',
            'title.regex'         => '文章標題 請勿輸入空白或者特殊符號',
            'created_at.required' => '請務必填寫 發布時間 欄位',
            // 'thumbnail.required'  => '請上傳一張圖片作為 文章顯示圖',
            'thumbnail.mimes'     => '縮圖的型態請為: :values.',
        ];
    }
}
