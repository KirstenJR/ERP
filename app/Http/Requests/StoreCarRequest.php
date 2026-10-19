<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
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
     **/
    public function rules(): array
    {
        return [
            'matricula'=>['required','string','max:20','unique:cars,matricula'],
            'fecha_inicio'=>['required','date'],
            'user_id'=>['nullable','date']
        ];
    }
    public function messages(): array
    {
        return[
            'matricula.required'=>'La matricula es obligatoria',
            'matricula.unique'=>'esa matricula ya está registrada',
            'fecha_inicio.required'=>'La fecha de inicio es obligatoria',
            'fecha_inicio.date'=>'la fecha de inicio no es valida',
            'user_id.exists'=>'el operador seleccionado no existe'
        ];
    }
}
