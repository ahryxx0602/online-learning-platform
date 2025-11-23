<?php
// root/Modules/User/app/Http
namespace Modules\User\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Đảm bảo locale là 'vi' để load translation đúng
        if (app()->getLocale() !== 'vi') {
            app()->setLocale('vi');
        }
    }

    public function rules()
    {
        $id = $this->route()->user;

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6',
            'group_id' => ['required','integer', function ($attribute, $value, $fail) {
                if($value === 0){
                    $fail(__('user::validation.select'));
                }
            }],
        ];
        // Nếu có $id thì validate lại mật khẩu và email (UPDATE)
        if($id){
            $rules['email'] = 'required|email|max:255|unique:users,email,'.$id;
            if($this->password){
                $rules['password'] = 'min:6';
            }else {
                unset($rules['password']);
            }
        }
        return $rules;
    }
    public function messages(){
        return [
            'name.required' => __('user::validation.required'),
            'email.required' => __('user::validation.required'),
            'email.email' => __('user::validation.email'),
            'email.unique' => __('user::validation.unique'),
            'password.required' => __('user::validation.required'),
            'password.min' => __('user::validation.min'),
            'group_id.required' => __('user::validation.required'),
            'group_id.integer' => __('user::validation.integer'),
        ];
    }

    public function attributes(){
        return [
            'name' => __('user::validation.attributes.name'),
            'email' => __('user::validation.attributes.email'),
            'password' => __('user::validation.attributes.password'),
            'group_id' => __('user::validation.attributes.group_id'),
        ];
    }

}
