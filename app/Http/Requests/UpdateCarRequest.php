<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'matricula' => [
                'required', 'string', 'max:20',
                Rule::unique('cars','matricula')->ignore($this->route('car')),
            ],
            'fecha_inicio' =>['required','date'],
            'user_id' => ['nullable', 'exists:users,id'],
        ];
    }

        public function messages(): array
    {
        return [
            'matricula.required' => 'La matrícula es obligatoria.',
            'matricula.unique'   => 'Esa matrícula ya está registrada.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date'     => 'La fecha de inicio no es válida.',
            'user_id.exists'        => 'El operador seleccionado no existe.',
        ];
    }

}
