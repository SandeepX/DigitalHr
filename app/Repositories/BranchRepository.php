<?php

namespace App\Repositories;

use App\Models\Branch;

class BranchRepository
{

    /**
     * @param $select
     * @return mixed
     */
    public function getAllCompanyBranches($select = ['*']): mixed
    {
        return Branch::select($select)->latest()->paginate(Branch::RECORDS_PER_PAGE);
    }

    /**
     * @param $validatedData
     * @return mixed
     */
    public function store($validatedData):mixed
    {
        return Branch::create($validatedData)->fresh();
    }

    public function getLoggedInUserCompanyBranches($companyId,$select=['*'])
    {
        return Branch::select($select)->where('company_id',$companyId)->get();
    }


    /**
     * @param $id
     * @return mixed
     */
    public function toggleStatus($id):mixed
    {
        $branchDetail = $this->findBranchDetailById($id);
        return $branchDetail->update([
            'is_active' => !$branchDetail->is_active,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findBranchDetailById($id,$with=[]):mixed
    {
        return Branch::with($with)->where('id',$id)->first();
    }

    public function update($branchDetail, $validatedData)
    {
        return $branchDetail->update($validatedData);
    }

    public function delete(Branch $branch)
    {
        return $branch->delete();
    }

}
