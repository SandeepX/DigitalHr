<?php

namespace App\Repositories;

use App\Helpers\AppHelper;
use App\Models\Support;

class SupportRepository
{
    public function getAllQueryDetail($filterParameters,$select=['*'],$with=[])
    {
       return Support::with($with)->select($select)
           ->when(isset($filterParameters['is_seen']), function ($query) use ($filterParameters) {
               $query->where('is_seen', $filterParameters['is_seen']);
           })
           ->when(isset($filterParameters['status']), function ($query) use ($filterParameters) {
               $query->where('status', $filterParameters['status']);
           })
           ->when(isset($filterParameters['query_from']), function($query) use ($filterParameters){
               $query->whereDate('created_at', '>=', AppHelper::dateInYmdFormatNepToEng($filterParameters['query_from']));
           })
           ->when(isset($filterParameters['query_to']), function($query) use ($filterParameters){
               $query->whereDate('created_at', '<=', AppHelper::dateInYmdFormatNepToEng($filterParameters['query_to']));
           })
           ->latest()
           ->paginate(Support::RECORDS_PER_PAGE);
    }

    public function findDetailById($id,$select=['*'])
    {
        return Support::select($select)
            ->where('id',$id)
            ->first();
    }

    public function store($validatedData)
    {
        return Support::create($validatedData)->fresh();
    }

    public function toggleIsSeenStatus($supportDetail)
    {
        return $supportDetail->update([
            'is_seen' => !$supportDetail->is_seen
        ]);
    }

    public function changeQueryStatus($supportDetail,$changedStatus)
    {
        return $supportDetail->update([
            'status' => $changedStatus
        ]);
    }

    public function changeStatusToSeen($supportDetail)
    {
        return $supportDetail->update([
            'is_seen' => 1
        ]);
    }

    public function delete($supportDetail)
    {
        return $supportDetail->delete();
    }

}
