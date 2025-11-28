<?php

namespace Modules\Courses\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoursesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    protected function prepareForValidation()
    {
        // Đảm bảo locale là 'vi'
        if (app()->getLocale() !== 'vi') {
            app()->setLocale('vi');
        }
    }


    public function rules()
    {
        $id = $this->route('courses'); // ĐÚNG

        $rules = [
            'name'        => 'required|max:255',
            'slug'        => 'required|max:255|unique:courses,slug',
            'detail'      => 'required',
            'teacher_id'  => ['required','integer', function ($attribute, $value, $fail) {
                if ($value == 0) {
                    $fail(__('courses::validation.select'));
                }
            }],
            'thumbnail'   => 'required|max:255',
            'code'        => 'required|max:50',
            'is_document' => 'required|integer',
            'supports'    => 'required|max:500',
            'status'      => 'required|integer',
            'sale_price'  => 'nullable|numeric',
        ];

        if ($id) {
            $rules['slug'] = 'required|max:255|unique:courses,slug,' . $id;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'        => __('courses::validation.required'),
            'slug.required'        => __('courses::validation.required'),
            'slug.unique'          => __('courses::validation.unique'),
            'detail.required'      => __('courses::validation.required'),
            'teacher_id.required'  => __('courses::validation.required'),
            'teacher_id.integer'   => __('courses::validation.integer'),
            'sale_price.numeric'   => __('courses::validation.numeric'),
            'is_document.required' => __('courses::validation.required'),
            'is_document.integer'  => __('courses::validation.integer'),
            'status.required'      => __('courses::validation.required'),
            'status.integer'       => __('courses::validation.integer'),
        ];
    }
    public function attributes()
    {
        return [
            'name'        => __('courses::validation.attributes.name'),
            'slug'        => __('courses::validation.attributes.slug'),
            'detail'      => __('courses::validation.attributes.detail'),
            'teacher_id'  => __('courses::validation.attributes.teacher_id'),
            'thumbnail'   => __('courses::validation.attributes.thumbnail'),
            'sale_price'  => __('courses::validation.attributes.sale_price'),
            'code'        => __('courses::validation.attributes.code'),
            'is_document' => __('courses::validation.attributes.is_document'),
            'supports'    => __('courses::validation.attributes.supports'),
            'status'      => __('courses::validation.attributes.status'),
        ];
    }
}
