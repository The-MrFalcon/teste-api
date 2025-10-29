<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UpdateRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'data_atendimento' => ['sometimes','required','date_format:Y-m-d H:i:s'],
            'diagnostico' => ['sometimes','required','string','max:1000'],
            'tratamento' => ['sometimes','required','string'],
            'observacoes' => ['nullable','string'],
        ];
    }
}
