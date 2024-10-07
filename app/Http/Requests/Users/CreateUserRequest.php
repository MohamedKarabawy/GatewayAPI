<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
        'branch' => ['required', 'string', 'exists:gt_branches,district'],
        'full_name' => ['required', 'string', 'max:40'],
        'email' => ['required', 'email', 'unique:gt_users,email'],
        'password' => ['required', 'string', 'min:8'],
        "role" => ['string','exists:gt_roles,role'],
        'phone_numbers.*' => ['required', 'regex:/[0-9]{10}/', 'numeric', 'unique:gt_usermeta,meta_value'],
        "is_activated" => ['boolean'],
        ];
    }
}
