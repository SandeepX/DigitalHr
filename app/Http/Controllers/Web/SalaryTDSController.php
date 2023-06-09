<?php

namespace App\Http\Controllers\Web;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Requests\Payroll\SalaryTDS\SalaryTDSUpdateRequest;
use App\Requests\Payroll\SalaryTDS\SalaryTDSStoreRequest;
use App\Services\Payroll\SalaryTDSService;
use Exception;

class SalaryTDSController extends Controller
{
    private $view = 'admin.payrollSetting.salaryTDS.';

    public function __construct(public SalaryTDSService $salaryTDSService)
    {
    }

    public function index()
    {
        try {
            $select = ['*'];
            $salaryTDSList = $this->salaryTDSService->getAllSalaryTDSListGroupByMaritalStatus($select);
            $singleSalaryTDS = $salaryTDSList->get('single', collect());
            $marriedSalaryTDS = $salaryTDSList->get('married', collect());
            return view($this->view . 'index', compact('singleSalaryTDS','marriedSalaryTDS'));
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }


    public function create()
    {
        try {
            return view($this->view . 'create');
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }


    public function store(SalaryTDSStoreRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $this->salaryTDSService->store($validatedData);
            return AppHelper::sendSuccessResponse('Salary TDS Detail Added Successfully');
        } catch (Exception $e) {
           return AppHelper::sendErrorResponse($e->getMessage(),$e->getCode());
        }
    }


    public function edit($id)
    {
        try {
            $salaryTDSDetail = $this->salaryTDSService->findSalaryTDSById($id);
            return view($this->view . 'edit',compact('salaryTDSDetail'));
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }


    public function update(SalaryTDSUpdateRequest $request, $id)
    {
        try{
            $validatedData = $request->validated();
            $salaryTDSDetail = $this->salaryTDSService->findSalaryTDSById($id);
            $this->salaryTDSService->updateDetail($salaryTDSDetail,$validatedData);
            return redirect()
                ->route('admin.salary-tds.index')
                ->with('success', 'TDS Detail Updated Successfully');
        }catch(Exception $exception){
            return redirect()
                ->back()
                ->with('danger', $exception->getMessage());
        }
    }


    public function deleteSalaryTDS($id)
    {
        try {
            $select = ['*'];
            $salaryTDSDetail = $this->salaryTDSService->findSalaryTDSById($id, $select);
            $this->salaryTDSService->deleteSalaryTDSDetail($salaryTDSDetail);
            return redirect()
                ->back()
                ->with('success', 'Salary TDS Detail Deleted Successfully');
        } catch (Exception $exception) {
            return redirect()
                ->back()
                ->with('danger', $exception->getMessage());
        }
    }

    public function toggleSalaryTDSStatus($id)
    {
        try {
            $select = ['*'];
            $salaryTDSDetail = $this->salaryTDSService->findSalaryTDSById($id, $select);
            $this->salaryTDSService->changeSalaryTDSStatus($salaryTDSDetail);
            return redirect()
                ->back()
                ->with('success', 'Status changed Successfully');
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }
}
