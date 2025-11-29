<?php

namespace Modules\Teachers\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeachersRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    protected function prepareForValidation()
    {
        // Đảm bảo load đúng file lang theo module teacher
        if (app()->getLocale() !== 'vi') {
            app()->setLocale('vi');
        }
    }

    public function rules()
    {
        $id = $this->route()->teacher; // Lấy ID nếu đang update

        $rules = [
            'name'        => 'required|max:100',
            'slug'        => 'required|max:100|unique:teachers,slug',
            'description' => 'nullable',
            'exp'         => 'required|numeric|min:0',
            'image'       => 'nullable|max:255',
        ];

        // Nếu có ID → đang update
        if ($id) {
            // unique nhưng bỏ qua chính nó
            $rules['slug'] = 'required|max:100|unique:teachers,slug,' . $id;
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'name.required'        => __('teacher::validation.required'),
            'slug.required'        => __('teacher::validation.required'),
            'slug.unique'          => __('teacher::validation.unique'),
            'exp.required'         => __('teacher::validation.required'),
            'exp.numeric'          => __('teacher::validation.numeric'),
            'exp.min'              => __('teacher::validation.min'),
        ];
    }
    public function attributes()
    {
        return [
            'name'        => __('teacher::validation.attributes.name'),
            'slug'        => __('teacher::validation.attributes.slug'),
            'description' => __('teacher::validation.attributes.description'),
            'exp'         => __('teacher::validation.attributes.exp'),
            'image'       => __('teacher::validation.attributes.image'),
        ];
    }
}
