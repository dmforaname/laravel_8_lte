<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UserStoreRequest extends FormRequest
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
        return [
            'email' => 'bail|required|unique:users,email',
            'name' => 'required|min:3',
            'role' => 'required',
            'password' => 'required|min:6'
        ];
    }

    /**
     * Modify validated data
     *
     * @return array
     */
    public function validated(): array
    {
        $data = parent::validated();
        $data['password'] = bcrypt($data['password']);
        
        return $data;
    }
}
