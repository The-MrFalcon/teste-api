<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'patient_id',
        'data_atendimento',
        'diagnostico',
        'tratamento',
        'observacoes',
    ];
    protected $casts = [
        'data_atendimento' => 'datetime',
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
