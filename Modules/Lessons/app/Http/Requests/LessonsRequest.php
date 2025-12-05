<?php

namespace Modules\Lessons\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Đảm bảo locale về vi để load đúng file lang
        if (app()->getLocale() !== 'vi') {
            app()->setLocale('vi');
        }
    }

    public function rules()
    {
        $id = $this->route('lesson');

        $rules = [
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:lessons,slug',
            'course_id'   => 'required|integer|exists:courses,id',
            'video'       => 'required|string',
            'document'    => 'nullable',
            'parent_id'   => 'integer',
            'is_trial'    => 'boolean',
            'position'    => 'required|integer|min:0',
            'description' => 'nullable',
        ];

        if ($id) {
            $rules['slug'] = 'required|string|max:255|unique:lessons,slug,'.$id;
            // Khi update, course_id không bắt buộc (giữ nguyên course hiện tại)
            $rules['course_id'] = 'nullable|integer|exists:courses,id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'        => trans('lessons::validation.required', ['attribute' => __('lessons::validation.attributes.name')]),
            'name.string'          => trans('lessons::validation.string', ['attribute' => __('lessons::validation.attributes.name')]),
            'name.max'             => trans('lessons::validation.max', ['attribute' => __('lessons::validation.attributes.name')]),
            'slug.required'        => trans('lessons::validation.required', ['attribute' => __('lessons::validation.attributes.slug')]),
            'slug.string'          => trans('lessons::validation.string', ['attribute' => __('lessons::validation.attributes.slug')]),
            'slug.unique'          => trans('lessons::validation.unique', ['attribute' => __('lessons::validation.attributes.slug')]),
            'slug.max'             => trans('lessons::validation.max', ['attribute' => __('lessons::validation.attributes.slug')]),
            'course_id.required'   => trans('lessons::validation.required', ['attribute' => __('lessons::validation.attributes.course_id')]),
            'course_id.integer'    => trans('lessons::validation.integer', ['attribute' => __('lessons::validation.attributes.course_id')]),
            'course_id.exists'     => trans('lessons::validation.exists', ['attribute' => __('lessons::validation.attributes.course_id')]),
            'video.required'       => trans('lessons::validation.required', ['attribute' => __('lessons::validation.attributes.video')]),
            'video.string'         => trans('lessons::validation.string', ['attribute' => __('lessons::validation.attributes.video')]),
            'document.string'      => trans('lessons::validation.string', ['attribute' => __('lessons::validation.attributes.document')]),
            'parent_id.integer'    => trans('lessons::validation.integer', ['attribute' => __('lessons::validation.attributes.parent_id')]),
            'is_trial.boolean'     => trans('lessons::validation.boolean', ['attribute' => __('lessons::validation.attributes.is_trial')]),
            'position.required'    => trans('lessons::validation.required', ['attribute' => __('lessons::validation.attributes.position')]),
            'position.integer'     => trans('lessons::validation.integer', ['attribute' => __('lessons::validation.attributes.position')]),
            'position.min'         => trans('lessons::validation.min', ['attribute' => __('lessons::validation.attributes.position')]),
        ];
    }

    public function attributes()
    {
        return [
            'name'        => __('lessons::validation.attributes.name'),
            'slug'        => __('lessons::validation.attributes.slug'),
            'course_id'   => __('lessons::validation.attributes.course_id'),
            'video'       => __('lessons::validation.attributes.video'),
            'document'    => __('lessons::validation.attributes.document'),
            'parent_id'   => __('lessons::validation.attributes.parent_id'),
            'is_trial'    => __('lessons::validation.attributes.is_trial'),
            'position'    => __('lessons::validation.attributes.position'),
            'description' => __('lessons::validation.attributes.description'),
        ];
    }
}
