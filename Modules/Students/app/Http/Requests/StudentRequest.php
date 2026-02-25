<?php

namespace Modules\Students\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    protected function prepareForValidation()
    {
        if (app()->getLocale() !== 'vi') {
            app()->setLocale('vi');
        }
    }

    public function rules(): array
    {
        
        $id = $this->route()->student;
        // 1. Khai báo rules mặc định (Áp dụng cho Thêm mới)
        $rules = [
            'name'     => 'required|max:100',
            'email'    => 'required|email|max:100|unique:students,email',
            'password' => 'required|min:6|max:100',
            'phone'    => 'nullable|max:20',
            'address'  => 'nullable|max:255',
            'status'   => 'nullable|boolean',
        ];

        // 2. Nếu có $id (Cập nhật), tiến hành ghi đè hoặc loại bỏ rule
        if ($id) {
            $rules['email'] = 'required|email|max:100|unique:students,email,' . $id;

            if ($this->filled('password')) { 
                $rules['password'] = 'min:6|max:100';
            } else {
                unset($rules['password']);
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required'     => __('students::validation.required'),
            'name.max'          => __('students::validation.max'),
            'email.required'    => __('students::validation.required'),
            'email.email'       => __('students::validation.email'),
            'email.unique'      => __('students::validation.unique'),
            'email.max'         => __('students::validation.max'),
            'password.required' => __('students::validation.required'),
            'password.min'      => __('students::validation.min'),
            'password.max'      => __('students::validation.max'),
            'phone.max'         => __('students::validation.max'),
            'address.max'       => __('students::validation.max'),
        ];
    }

    public function attributes(): array
    {
        return [
            'name'     => __('students::validation.attributes.name'),
            'email'    => __('students::validation.attributes.email'),
            'password' => __('students::validation.attributes.password'),
            'phone'    => __('students::validation.attributes.phone'),
            'address'  => __('students::validation.attributes.address'),
            'status'   => __('students::validation.attributes.status'),
        ];
    }
}