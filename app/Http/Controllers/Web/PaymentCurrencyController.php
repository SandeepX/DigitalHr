<?php

namespace App\Http\Controllers\Web;

use App\Helpers\PaymentCurrencyHelper;
use App\Http\Controllers\Controller;
use App\Repositories\PaymentCurrencyRepository;
use Exception;
use Illuminate\Http\Request;


class PaymentCurrencyController extends Controller
{

    private $view = 'admin.payrollSetting.paymentCurrency.';

    public function __construct(public PaymentCurrencyRepository $paymentCurrencyRepo)
    {
    }

    public function index()
    {
        try{
            $select = ['id','code'];
            $currencyDetail = $this->paymentCurrencyRepo->findPayrollCurrency($select);
            return view($this->view . 'index',compact('currencyDetail'));
        }catch(\Exception $e){
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function updateOrSetPaymentCurrency(Request $request)
    {
        try{
            $currencyId = $request->get('currency');
            $currencies = \Illuminate\Support\Collection::make( PaymentCurrencyHelper::CURRENCY_DETAIL);
            $currencyData = $currencies->firstWhere('id', $currencyId);
            $currencyDetail = $this->paymentCurrencyRepo->findPayrollCurrency();
            if(!$currencyDetail){
                throw new Exception('Currency Detail Not Found',404);
            }
            $this->paymentCurrencyRepo->updateOrCreatePaymentCurrency($currencyDetail,$currencyData);
            return redirect()
                ->back()
                ->with('success','Payment Currency Updated Successfully');
        }catch(Exception $exception){
            return redirect()->back()
                ->with('danger', $exception->getMessage())
                ->withInput();
        }
    }
}
