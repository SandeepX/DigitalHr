<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{

    public function getAllFilteredProjects($filterParameters,$select,$with): mixed
    {
        return Project::query()->select($select)->with($with)

        ->when(isset($filterParameters['project_name']), function ($query) use ($filterParameters) {
            $query->where('id', $filterParameters['project_name']);
        })
        ->when(isset($filterParameters['status']), function ($query) use ($filterParameters) {
            $query->where('status', $filterParameters['status']);
        })
        ->when(isset($filterParameters['priority']), function ($query) use ($filterParameters) {
            $query->where('priority', $filterParameters['priority']);
        })
        ->when(isset($filterParameters['members']), function ($query) use ($filterParameters) {
            $query->whereHas('assignedMembers.user',function($subQuery) use ($filterParameters){
                    $subQuery->whereIn('id', $filterParameters['members']);
                });
         })
        ->latest()
        ->paginate(Project::RECORDS_PER_PAGE);
    }

    public function getAllActiveProject($select=['*'], $with=[])
    {
        return Project::select($select)->with($with)
            ->where('is_active',1)
            ->get();
    }

    public function store($validatedData):mixed
    {
        return Project::create($validatedData)->fresh();
    }

    public function toggleStatus($projectDetail):mixed
    {
        return $projectDetail->update([
            'is_active' => !$projectDetail->is_active,
        ]);
    }

    public function findProjectDetailById($id,$with,$select):mixed
    {
        return Project::select($select)
            ->with($with)
            ->where('id',$id)
            ->first();
    }

    public function getAllProjectLists($select)
    {
        return Project::select($select)->latest()->get();
    }

    public function findAssignedMemberProjectDetailById($projectId,$with,$select):mixed
    {
        return Project::select($select)
            ->with($with)
            ->where(function($query){
                $query->whereHas('assignedMembers',function($subQuery){
                    $subQuery->where('member_id', getAuthUserCode());
                })
                ->orWhereHas('projectLeaders', function ($subQuery) {
                    $subQuery->where('leader_id', getAuthUserCode());
                });
            })
            ->where('id',$projectId)
            ->where('is_active',1)
            ->first();
    }

    public function getAllActiveProjectsOfEmployee($employeeId,$with,$select)
    {
        return Project::select($select)->with($with)
            ->where(function($query) use ($employeeId){
                $query->whereHas('assignedMembers.user',function($subQuery) use ($employeeId){
                    $subQuery->where('id', $employeeId);
                })
                ->orWhereHas('projectLeaders', function ($subQuery) {
                    $subQuery->where('leader_id', getAuthUserCode());
                });
            })
            ->where('is_active',1)
            ->get();
    }

    public function getAllActiveProjectsOfEmployeePaginated($employeeId,$with,$select,$perPage)
    {
        $paginate = isset($perPage) ? $perPage : (Project::RECORDS_PER_PAGE);
        return Project::select($select)->with($with)
            ->where(function($query) use ($employeeId){
                $query->whereHas('assignedMembers.user',function($subQuery) use ($employeeId){
                    $subQuery->where('id', $employeeId);
                })
                ->orWhereHas('projectLeaders', function ($subQuery) {
                    $subQuery->where('leader_id', getAuthUserCode());
                });
            })
            ->where('is_active',1)
            ->paginate($paginate);
    }

    public function update($projectDetail, $validatedData)
    {
        $projectDetail->update($validatedData);
        if(isset($validatedData['attachments'])){
            $projectDetail->projectAttachments()->delete();
        }
        $projectDetail->assignedMembers()->delete();
        return $projectDetail->projectLeaders()->delete();
    }

    public function changeProjectProgressStatus($projectDetail,$projectStatus)
    {
        return $projectDetail->update([
            'status' => $projectStatus
        ]);
    }

    public function delete(Project $projectDetail)
    {
        return $projectDetail->delete();
    }

    public function dropAssignedMembers($projectDetail)
    {
        $projectDetail->assignedMembers()->delete();
        return true;
    }

    public function assignMemberToProject(Project $projectDetail,$assignedMemberArray)
    {
        return $projectDetail->assignedMembers()->createMany($assignedMemberArray);
    }

    public function saveProjectTeamLeader(Project $projectDetail,$teamLeaderArray)
    {
        return $projectDetail->projectLeaders()->createMany($teamLeaderArray);
    }

}
