<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $patientId = $this->route('id') ?? $this->route('patient');
        return [
            'nome' => ['sometimes','required','string','max:255'],
            'cpf' => ['sometimes','required','string','size:11','unique:patients,cpf,' . $patientId],
            'data_nascimento' => ['sometimes','required','date'],
            'email' => ['sometimes','required','email','max:255','unique:patients,email,' . $patientId],
            'telefone' => ['nullable','string','max:20'],
        ];
    }
}
