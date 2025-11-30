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
            'description' => 'required',
            'exp'         => 'required|numeric|min:0',
            'image'       => 'required|max:255',
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
            'name.required'        => __('teachers::validation.required'),
            'slug.required'        => __('teachers::validation.required'),
            'slug.unique'          => __('teachers::validation.unique'),
            'exp.required'         => __('teachers::validation.required'),

            'exp.numeric'          => __('teachers::validation.numeric'),
            'exp.min'              => __('teachers::validation.min'),

            'description.required' => __('teachers::validation.required'),
            'image.required'       => __('teachers::validation.required'),
            'image.max'            => __('teachers::validation.max'),
        ];
    }
    public function attributes()
    {
        return [
            'name'        => __('teachers::validation.attributes.name'),
            'slug'        => __('teachers::validation.attributes.slug'),
            'description' => __('teachers::validation.attributes.description'),
            'exp'         => __('teachers::validation.attributes.exp'),
            'image'       => __('teachers::validation.attributes.image'),
        ];
    }
}
