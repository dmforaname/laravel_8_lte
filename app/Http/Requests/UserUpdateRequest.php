<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Repositories\Api\UserRepository;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = User::uuid($this->route('uuid'))->id;

        return [
            'email' => 'bail|required|unique:users,email,'.$id,
            'name' => 'required',
            'role' => 'required'
        ];
    }
}
