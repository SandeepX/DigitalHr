<?php

namespace App\Repositories;

use App\Models\Department;
use Illuminate\Support\Str;

class DepartmentRepository
{

    /**
     * @param $with
     * @param $select
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllPaginatedDepartments($with=[], $select=['*'])
    {
        return Department::with($with)
            ->select($select)
            ->latest()
            ->paginate(Department::RECORDS_PER_PAGE);
    }

    /**
     * @param $with
     * @param $select
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllActiveDepartments($with=[], $select=['*'])
    {
        return Department::with($with)
            ->select($select)
            ->where('is_active',1)
            ->get();
    }

    public function getAllActiveDepartmentsByBranchId($branchId,$with=[], $select=['*'])
    {
        return Department::with($with)
            ->select($select)
            ->where('is_active',1)
            ->where('branch_id',$branchId)
            ->get();
    }


    /**
     * @param $id
     * @param $select
     * @return mixed
     */
    public function findDepartmentById($id, $select=['*'],$with=[])
    {
        return Department::select($select)->where('id',$id)->first();
    }

    /**
     * @param $validatedData
     * @return mixed
     */
    public function store($validatedData)
    {
        $validatedData['slug'] = Str::slug($validatedData['dept_name']);
        return Department::create($validatedData)->fresh();
    }

    /**
     * @param $departmentDetail
     * @return mixed
     */
    public function delete($departmentDetail)
    {
        return $departmentDetail->delete();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function toggleStatus($id)
    {
        $departmentDetail = $this->findDepartmentById($id);
        return $departmentDetail->update([
            'is_active' => !$departmentDetail->is_active,
        ]);
    }

    /**
     * @param $departmentDetail
     * @param $validatedData
     * @return mixed
     */
    public function update($departmentDetail, $validatedData)
    {
       return $departmentDetail->update($validatedData);
    }

}
