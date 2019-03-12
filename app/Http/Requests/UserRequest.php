<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $createRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:191',
            'username' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ];     

        switch($this->method()) {
            case 'POST':
                $createRules['email'] .= '|unique:users';
                $createRules['username'] .= '|unique:users';
                return $createRules;
                break;
            case 'PUT':
                $createRules['password'] = str_replace('required', 'nullable', $createRules['password']);               
                break;
            default:
                return [];
                break;
        }
        
        return $createRules;
        
    }

    public function attributes()
    {
        return [
            'name' => 'nome',
            'email' => 'email',
            'password' => 'senha',
            'username' => 'nome de usuário'
        ];
    }
}