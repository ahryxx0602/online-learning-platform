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
        $id = $this->route('student'); 

        $rules = [
            'name'     => 'required|max:100',
            'email'    => 'required|email|max:100|unique:students,email', // Đổi sang bảng students
            'password' => 'required|min:6|max:100',
            'phone'    => 'nullable|max:20',
            'address'  => 'nullable|max:255',
            'status'   => 'nullable|boolean',
        ];

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
            'name.required'     => __('user::validation.required'),
            'name.max'          => __('user::validation.max'),
            'email.required'    => __('user::validation.required'),
            'email.email'       => __('user::validation.email'),
            'email.unique'      => __('user::validation.unique'),
            'email.max'         => __('user::validation.max'),
            'password.required' => __('user::validation.required'),
            'password.min'      => __('user::validation.min'),
            'password.max'      => __('user::validation.max'),
            'phone.max'         => __('user::validation.max'),
            'address.max'       => __('user::validation.max'),
        ];
    }

    public function attributes(): array
    {
        return [
            'name'     => __('user::validation.attributes.name'),
            'email'    => __('user::validation.attributes.email'),
            'password' => __('user::validation.attributes.password'),
            'phone'    => __('user::validation.attributes.phone'),
            'address'  => __('user::validation.attributes.address'),
            'status'   => __('user::validation.attributes.status'),
        ];
    }
}