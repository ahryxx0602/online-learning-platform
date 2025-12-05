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
            'course_id'   => 'required|integer',
            'video_id'    => 'nullable|integer',
            'document_id' => 'nullable|integer',
            'parent_id'   => 'nullable|integer',
            'is_trial'    => 'sometimes|boolean',
            'views'       => 'nullable|integer|min:0',
            'position'    => 'nullable|integer',
            'duration'    => 'nullable|numeric',
            'description' => 'nullable|string',
        ];

        if ($id) {
            $rules['slug'] = 'required|string|max:255|unique:lessons,slug,'.$id;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'      => __('lessons::validation.required'),
            'slug.required'      => __('lessons::validation.required'),
            'slug.unique'        => __('lessons::validation.unique'),
            'course_id.required' => __('lessons::validation.required'),
            'course_id.integer'  => __('lessons::validation.integer'),
            'video_id.integer'   => __('lessons::validation.integer'),
            'document_id.integer'=> __('lessons::validation.integer'),
            'parent_id.integer'  => __('lessons::validation.integer'),
            'is_trial.boolean'   => __('lessons::validation.boolean'),
            'views.integer'      => __('lessons::validation.integer'),
            'views.min'          => __('lessons::validation.min'),
            'position.integer'   => __('lessons::validation.integer'),
            'duration.numeric'   => __('lessons::validation.numeric'),
        ];
    }

    public function attributes()
    {
        return [
            'name'        => __('lessons::validation.attributes.name'),
            'slug'        => __('lessons::validation.attributes.slug'),
            'course_id'   => __('lessons::validation.attributes.course_id'),
            'video_id'    => __('lessons::validation.attributes.video_id'),
            'document_id' => __('lessons::validation.attributes.document_id'),
            'parent_id'   => __('lessons::validation.attributes.parent_id'),
            'is_trial'    => __('lessons::validation.attributes.is_trial'),
            'views'       => __('lessons::validation.attributes.views'),
            'position'    => __('lessons::validation.attributes.position'),
            'duration'    => __('lessons::validation.attributes.duration'),
            'description' => __('lessons::validation.attributes.description'),
        ];
    }
}