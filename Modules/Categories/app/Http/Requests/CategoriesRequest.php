<?php

namespace Modules\Categories\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Modules\Categories\Models\Category;

class CategoriesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Đảm bảo load đúng file lang (vi)
        if (app()->getLocale() !== 'vi') {
            app()->setLocale('vi');
        }

        // Nếu parent_id rỗng thì set về 0
        $parentId = $this->input('parent_id');
        if ($parentId === null || $parentId === '') {
            $this->merge(['parent_id' => 0]);
        }

        // Nếu slug không nhập → tự sinh từ name
        if (!$this->filled('slug') && $this->filled('name')) {
            $this->merge([
                'slug' => Str::slug($this->input('name'))
            ]);
        }
    }

    public function rules()
    {
        // Lấy id khi update
        $id = $this->route('category');

        return [
            'name' => 'required|string|max:255',

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($id),
            ],

            'parent_id' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use ($id) {

                    // Nếu = 0 → không có danh mục cha → hợp lệ
                    if ((int)$value === 0) return;

                    // Không được chọn chính nó làm cha
                    if ($id && (int)$value === (int)$id) {
                        return $fail(__('categories::validation.parent_invalid'));
                    }

                    // Kiểm tra danh mục cha có tồn tại không
                    if (!Category::where('id', $value)->exists()) {
                        return $fail(__('categories::validation.parent_not_found'));
                    }
                }
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required'   => __('categories::validation.required'),
            'slug.required'   => __('categories::validation.required'),
            'slug.unique'     => __('categories::validation.unique'),
            'parent_id.required' => __('categories::validation.required'),
            'parent_id.integer'  => __('categories::validation.integer'),
            'parent_id.min'      => __('categories::validation.min'),
        ];
    }

    public function attributes()
    {
        return [
            'name'      => __('categories::validation.attributes.name'),
            'slug'      => __('categories::validation.attributes.slug'),
            'parent_id' => __('categories::validation.attributes.parent_id'),
        ];
    }
}
