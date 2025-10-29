<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'data_atendimento' => ['required','date_format:Y-m-d H:i:s'],
            'diagnostico' => ['required','string','max:1000'],
            'tratamento' => ['required','string'],
            'observacoes' => ['nullable','string'],
        ];
    }
}
