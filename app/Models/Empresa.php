<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
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