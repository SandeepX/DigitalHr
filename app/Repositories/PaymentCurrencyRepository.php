<?php

namespace App\Repositories;

use App\Models\PaymentCurrency;

class PaymentCurrencyRepository
{
    public function findPayrollCurrency($select=['*'])
    {
        return PaymentCurrency::select($select)->first();
    }

    public function updateOrCreatePaymentCurrency($currencyDetail,$validatedData)
    {
        if($currencyDetail){
            return $currencyDetail->update($validatedData);
        }
        return PaymentCurrency::create($validatedData);
    }
}
