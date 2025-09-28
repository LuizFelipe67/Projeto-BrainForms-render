<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlunoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:105',
            'email' => 'required|string|email|max:100|unique:alunos,email',
            'password' => 'required|string|min:6|regex:/[A-Za-z]/|confirmed',
        ];
    }

    /**
     * Custom messages for validation errors
     */
    public function messages(): array
    {
        return [
            'required' => 'O :attribute é obrigatório.',
            'string'   => 'O :attribute deve ser um texto válido.',
            'max'      => 'O :attribute não pode ultrapassar :max caracteres.',
            'email'    => 'O :attribute deve conter um endereço de email válido com @.',
            'unique'   => 'O :attribute informado já está em uso.',
            'password.regex' => 'A senha deve conter pelo menos uma letra.',
            'min'      => 'O campo :attribute deve ter pelo menos :min caracteres.',
            'confirmed'=> 'A confirmação da :attribute estar incorreta.'
        ];
    }

    /**
     * Custom attribute names for messages
     */
    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'email' => 'e-mail',
            'password' => 'senha',
            'password_confirmation' => 'confirmação de senha',
        ];
    }
}
