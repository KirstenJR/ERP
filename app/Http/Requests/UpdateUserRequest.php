<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;


class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
<?php
 
namespace App\Http\Requests;
 
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
 
class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
 
    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($this->route('user')),
            ],
            'role'     => ['required', 'in:admin,operador'],
            'password' => ['nullable', 'confirmed', Password::min(8)],
                ];
            }
        
            public function messages(): array
            {
                return [
                    'name.required'      => 'El nombre es obligatorio.',
                    'email.required'     => 'El correo es obligatorio.',
                    'email.email'        => 'El correo no es válido.',
                    'email.unique'       => 'Ese correo ya está registrado.',
                    'role.in'            => 'El rol debe ser admin u operador.',
                    'password.confirmed' => 'La confirmación de la contraseña no coincide.',
                ];
            }
        }
