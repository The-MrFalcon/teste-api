<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'nome' => ['required','string','max:255'],
            'cpf' => ['required','string','size:11','unique:patients,cpf'],
            'data_nascimento' => ['required','date'],
            'email' => ['required','email','max:255','unique:patients,email'],
            'telefone' => ['nullable','string','max:20'],
        ];
    }
}
