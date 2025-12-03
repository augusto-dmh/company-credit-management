<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnpj',
        'icms_pago',
        'credito_possivel',
    ];

    protected $casts = [
        'icms_pago' => 'decimal:2',
        'credito_possivel' => 'decimal:2',
    ];

    protected $appends = ['percentual_credito'];

    public function getCnpjFormatadoAttribute(): string
    {
        $cnpj = preg_replace('/\D/', '', $this->cnpj);

        return preg_replace(
            '/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/',
            '$1.$2.$3/$4-$5',
            $cnpj
        );
    }

    public function getPercentualCreditoAttribute(): float
    {
        if ($this->icms_pago <= 0) {
            return 0;
        }

        return round(($this->credito_possivel / $this->icms_pago) * 100, 2);
    }

    public function getIcmsPagoFormatadoAttribute(): string
    {
        return 'R$ ' . number_format($this->icms_pago, 2, ',', '.');
    }

    public function getCreditoPossivelFormatadoAttribute(): string
    {
        return 'R$ ' . number_format($this->credito_possivel, 2, ',', '.');
    }
}
