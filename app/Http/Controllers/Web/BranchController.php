<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\BranchRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use App\Requests\Branch\BranchRequest;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{

    private $view = 'admin.branch.';

    private BranchRepository $branchRepo;
    private CompanyRepository $companyRepo;
    private UserRepository $userRepo;

    public function __construct(BranchRepository $branchRepo,
                                CompanyRepository $companyRepo,
                                UserRepository $userRepo
    )
    {
        $this->branchRepo = $branchRepo;
        $this->companyRepo = $companyRepo;
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $this->authorize('list_branch');
        try{
            $branches = $this->branchRepo->getAllCompanyBranches();
            return view($this->view.'index', compact('branches'));
        }catch(\Exception $exception){
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function create()
    {
        $this->authorize('create_branch');
        try{
            $select=['name','id'];
            $users = $this->userRepo->getAllUsersForBranch($select);
            $company = $this->companyRepo->getCompanyDetail(['id','name']);
            return response()->json([
                'users' => $users,
                'company' => $company,
            ]);
        }catch(\Exception $exception){
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function store(BranchRequest $request)
    {
        $this->authorize('create_branch');
        try{
            $validatedData = $request->validated();
            DB::beginTransaction();
                $this->branchRepo->store($validatedData);
            DB::commit();
            return redirect()->route('admin.branch.index')->with('success', 'New Branch Added Successfully');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()
                ->route('admin.branch.index')
                ->with('danger', $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $this->authorize('edit_branch');
        try{
            $branch = $this->branchRepo->findBranchDetailById($id);
            $branchHeads = $this->userRepo->getAllUsersForBranch(['name','id']);;
            return response()->json([
                'data' => $branch,
                'users' => $branchHeads
            ]);
        }catch(\Exception $exception){
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function update(BranchRequest $request,$id)
    {
        $this->authorize('edit_branch');
        try{
            $validatedData = $request->validated();
            $branchDetail = $this->branchRepo->findBranchDetailById($id);
            if(!$branchDetail){
                throw new \Exception('Branch Detail Not Found',404);
            }
            DB::beginTransaction();
             $branch = $this->branchRepo->update($branchDetail,$validatedData);
            DB::commit();
            return redirect()->back()->with('success', 'Branch Detail Updated Successfully');
        }catch(\Exception $exception){
            return redirect()->back()->with('danger', $exception->getMessage())->withInput();
        }
    }

    public function toggleStatus($id)
    {
        $this->authorize('edit_branch');
        try{
            DB::beginTransaction();
                $this->branchRepo->toggleStatus($id);
            DB::commit();
            return redirect()->back()->with('success', 'Status changed  Successfully');
        }catch(\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('danger',$exception->getMessage());
        }
    }

    public function delete($id)
    {
        $this->authorize('delete_branch');
        try{
            $with = ['departments','routers'];
            $branchDetail = $this->branchRepo->findBranchDetailById($id,$with);
            if(!$branchDetail){
                throw new \Exception('Branch Record Not Found',404);
            }
            if(count($branchDetail->departments) > 0){
                throw new \Exception('Cannot Delete Branch With Departments',403);
            }
            if(count($branchDetail->routers) > 0){
                throw new \Exception('Cannot Delete Branch With Router Detail',403);
            }
            DB::beginTransaction();
                $this->branchRepo->delete($branchDetail);
            DB::commit();
            return redirect()->back()->with('success', 'Branch Record Deleted  Successfully');
        }catch(\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('danger',$exception->getMessage());
        }
    }
}
