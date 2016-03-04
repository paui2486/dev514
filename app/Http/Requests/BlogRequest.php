<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class BlogRequest extends FormRequest
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
            'title'       => 'required|unique:articles,title|min:3|max:255',
            'created_at'  => 'required|date',
            'thumbnail'   => 'required|mimes:jpeg,bmp,png',
        ];
    }

    public function messages()
    {
        return [
            'title.required'      => '請務必填寫 文章標題 欄位',
            'title.min'           => '文章標題 最少 :min 字元',
            'title.max'           => '文章標題 最多 :max 字元',
            'created_at.required' => '請務必填寫 發布時間 欄位',
            'thumbnail.required'  => '請上傳一張圖片作為文章顯示圖',
            'thumbnail.mimes'     => '縮圖的型態請為: :values.',
        ];
    }
}
