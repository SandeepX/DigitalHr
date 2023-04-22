<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\CompanyRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\UserRepository;
use App\Requests\Department\DepartmentStoreRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    private $view = 'admin.department.';

    private DepartmentRepository $departmentRepo;
    private CompanyRepository $companyRepo;
    private UserRepository $userRepo;

    public function __construct(DepartmentRepository $departmentRepo,
                                CompanyRepository    $companyRepo,
                                UserRepository $userRepo)
    {
        $this->departmentRepo = $departmentRepo;
        $this->companyRepo = $companyRepo;
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $this->authorize('list_department');
        try {
            $with = ['branch:id,name', 'departmentHead:id,name'];
            $departments = $this->departmentRepo->getAllPaginatedDepartments($with);
            return view($this->view . 'index', compact('departments'));
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function create()
    {
        $this->authorize('create_department');
        try {
            $select = ['name','id'];
            $users = $this->userRepo->getAllUsers($select);
            $with = ['branches:company_id,id,name'];
            $select = ['id', 'name'];
            $companyDetail = $this->companyRepo->getCompanyDetail($select, $with);
            return view($this->view . 'create',
                compact('companyDetail', 'users')
            );
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function getAllDepartmentsByBranchId($branchId): JsonResponse|RedirectResponse
    {
        $this->authorize('create_department');
        try {
            $with = [];
            $select = ['dept_name', 'id'];
            $departments = $this->departmentRepo->getAllActiveDepartmentsByBranchId($branchId,$with,$select);
            return response()->json([
                'data' => $departments
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }


    public function store(DepartmentStoreRequest $request)
    {
        $this->authorize('create_department');
        try {
            $validatedData = $request->validated();
            DB::beginTransaction();
            $this->departmentRepo->store($validatedData);
            DB::commit();
            return redirect()->back()->with('success', 'New Department Added Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('admin.departments.index')
                ->with('danger', $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $this->authorize('edit_department');
        try {
            $departmentsDetail = $this->departmentRepo->findDepartmentById($id);
            $users = User::select('name', 'id')->get();
            $with = ['branches:company_id,id,name'];
            $select = ['id', 'name'];
            $companyDetail = $this->companyRepo->getCompanyDetail($select, $with);
            return view($this->view . 'edit',
                compact('companyDetail', 'users', 'departmentsDetail')
            );
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function update(DepartmentStoreRequest $request, $id)
    {
        $this->authorize('edit_department');
        try {
            $validatedData = $request->validated();
            $departmentDetail = $this->departmentRepo->findDepartmentById($id);
            if (!$departmentDetail) {
                throw new Exception('Department Detail Not Found', 404);
            }
            DB::beginTransaction();
            $department = $this->departmentRepo->update($departmentDetail, $validatedData);
            DB::commit();
            return redirect()->back()->with('success', 'Department Detail Updated Successfully');
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage())->withInput();
        }

    }

    public function toggleStatus($id)
    {
        $this->authorize('edit_department');
        try {
            DB::beginTransaction();
            $this->departmentRepo->toggleStatus($id);
            DB::commit();
            return redirect()->back()->with('success', 'Status changed  Successfully');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function delete($id)
    {
        $this->authorize('delete_department');
        try {
            $select = ['*'];
            $with = ['posts'];
            $departmentDetail = $this->departmentRepo->findDepartmentById($id,$select,$with);
            if (!$departmentDetail) {
                throw new Exception('Department Record Not Found', 404);
            }
            if(count($departmentDetail->posts) > 0){
                throw new Exception('Cannot Delete Department With Posts',403);
            }

            DB::beginTransaction();
            $this->departmentRepo->delete($departmentDetail);
            DB::commit();
            return redirect()->back()->with('success', 'Department Record Deleted  Successfully');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

}
