<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Requests\Payroll\SalaryGroup\SalaryGroupRequest;
use App\Services\Payroll\SalaryComponentService;
use App\Services\Payroll\SalaryGroupService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SalaryGroupController extends Controller
{

    private $view = 'admin.payrollSetting.salaryGroup.';

    public function __construct(
        public SalaryGroupService     $salaryGroupService,
        public SalaryComponentService $salaryComponentService,
        public UserRepository $userRepo
    )
    {
    }

    public function index(): Factory|View|RedirectResponse|Application
    {
        try {
            $select = ['*'];
            $with = ['salaryComponents:name'];
            $salaryGroupLists = $this->salaryGroupService->getAllSalaryGroupDetailList($select, $with);
            return view($this->view . 'index', compact('salaryGroupLists'));
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function create(): Factory|View|RedirectResponse|Application
    {
        try {
            $salaryComponents = $this->salaryComponentService->pluckAllActiveSalaryComponent();
            $employees = $this->userRepo->pluckIdAndNameOfAllVerifiedEmployee();
            return view($this->view . 'create', compact('salaryComponents','employees'));
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function store(SalaryGroupRequest $request): RedirectResponse
    {
        try {
            $validatedData = $request->validated();
            $this->salaryGroupService->store($validatedData);
            return redirect()
                ->route('admin.salary-groups.index')
                ->with('success', 'Salary Group Added Successfully');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('danger', $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id): Factory|View|RedirectResponse|Application
    {
        try {
            $groupSelect = ['*'];
            $with = ['salaryComponents:id,name','groupEmployees:salary_group_id,employee_id'];
            $salaryGroupDetail = $this->salaryGroupService->findOrFailSalaryGroupDetailById($id,$groupSelect,$with);
            $salaryComponents = $this->salaryComponentService->pluckAllActiveSalaryComponent();
            $employees = $this->userRepo->pluckIdAndNameOfAllVerifiedEmployee();

            $salaryGroupComponentId = $salaryGroupDetail?->salaryComponents?->pluck('id')->toArray() ?? [];
            $salaryGroupEmployeeId = $salaryGroupDetail?->groupEmployees?->pluck('employee_id')->toArray() ?? [];

            return view($this->view . 'edit', compact('salaryGroupDetail',
                'salaryComponents','salaryGroupComponentId','salaryGroupEmployeeId','employees'));
        } catch (Exception $exception) {
            return redirect()
                ->back()
                ->with('danger', $exception->getMessage());
        }
    }

    public function update(SalaryGroupRequest $request, $id): RedirectResponse
    {
        try {
            $select = ['*'];
            $validatedData = $request->validated();
            $salaryGroupDetail = $this->salaryGroupService->findOrFailSalaryGroupDetailById($id, $select);
            $this->salaryGroupService->updateDetail($salaryGroupDetail,$validatedData);
            return redirect()
                ->route('admin.salary-groups.index')
                ->with('success', 'Salary Group Detail Updated Successfully');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('danger', $e->getMessage())
                ->withInput();
        }
    }

    public function deleteSalaryGroup($id): RedirectResponse
    {
        try {
            $select = ['*'];
            $salaryGroupDetail = $this->salaryGroupService->findOrFailSalaryGroupDetailById($id, $select);
            $this->salaryGroupService->deleteSalaryGroupDetail($salaryGroupDetail);
            return redirect()
                ->back()
                ->with('success', 'Salary Group Detail Deleted Successfully');
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function toggleSalaryGroupStatus($id): RedirectResponse
    {
        try {
            $select = ['*'];
            $salaryGroupDetail = $this->salaryGroupService->findOrFailSalaryGroupDetailById($id, $select);
            $this->salaryGroupService->changeSalaryGroupStatus($salaryGroupDetail);
            return redirect()
                ->back()
                ->with('success', 'Status changed Successfully');
        } catch (Exception $exception) {
            return redirect()
                ->back()
                ->with('danger', $exception->getMessage());
        }
    }

}
