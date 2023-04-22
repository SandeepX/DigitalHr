<?php

namespace App\Repositories;

use App\Helpers\AppHelper;
use App\Models\User;
use App\Traits\ImageService;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    use ImageService;

    public function getAllUsers($filterParameters, $select = ['*'], $with = [])
    {
        return User::with($with)
            ->select($select)
            ->when(isset($filterParameters['employee_name']), function ($query) use ($filterParameters) {
                $query->where('name', 'like', '%' . $filterParameters['employee_name'] . '%');
            })
            ->when(isset($filterParameters['email']), function ($query) use ($filterParameters) {
                $query->where('email', 'like', '%' . $filterParameters['email'] . '%');
            })
            ->when(isset($filterParameters['phone']), function ($query) use ($filterParameters) {
                $query->where('phone', $filterParameters['phone']);
            })
            ->latest()
            ->paginate(User::RECORDS_PER_PAGE);
    }

    public function getAllUsersForBranch($select = ['*'],$with=[])
    {
        return User::select($select)->with($with)->get();
    }

    public function getAllVerifiedEmployeeOfCompany($select = ['*'], $with = [])
    {
        return User::select($select)->with($with)
            ->where('status', 'verified')
            ->where('is_active', 1)
            ->get();
    }

    public function store($validatedData)
    {
        $validatedData['created_by'] = getAuthUserCode();
        $validatedData['avatar'] = $this->storeImage($validatedData['avatar'], User::AVATAR_UPLOAD_PATH, 500, 500);
        return User::create($validatedData)->fresh();
    }

    public function changePassword($userDetail, $newPassword)
    {
        return $userDetail->update([
            'password' => bcrypt($newPassword)
        ]);
    }

    public function delete($userDetail)
    {
        if ($userDetail['avatar']) {
            $this->removeImage(User::AVATAR_UPLOAD_PATH, $userDetail['avatar']);
        }
        return $userDetail->delete();
    }

    public function update($userDetail, $validatedData)
    {
        if (isset($validatedData['avatar'])) {
            if ($userDetail['avatar']) {
                $this->removeImage(User::AVATAR_UPLOAD_PATH, $userDetail['avatar']);
            }
            $validatedData['avatar'] = $this->storeImage($validatedData['avatar'], User::AVATAR_UPLOAD_PATH, 500, 500);
        }
        return $userDetail->update($validatedData);
    }

    public function updateProfileForApi($userDetail, $validatedData)
    {
        if (isset($validatedData['avatar'])) {
            $this->removeImage(User::AVATAR_UPLOAD_PATH, $userDetail['avatar']);
        }
        $userDetail->update($validatedData);
        return $userDetail;
    }

    public function toggleIsActiveStatus($id)
    {
        $userDetail = $this->findUserDetailById($id);
        return $userDetail->update([
            'is_active' => !$userDetail->is_active,
        ]);
    }

    public function findUserDetailById($id, $select = ['*'], $with = [])
    {
        return User::with($with)->select($select)->where('id', $id)->first();
    }

    public function changeWorkSpace($userDetail)
    {
        return $userDetail->update([
            'workspace_type' => !$userDetail->workspace_type,
        ]);
    }

    public function updateUserOnlineStatus($userDetail, $loginStatus)
    {
        return $userDetail->update([
            'online_status' => $loginStatus,
        ]);
    }

    public function getUserByUserName($userName, $select = ['*'])
    {
        return User::select($select)
            ->where('username', $userName)
            ->where('is_active', 1)
            ->where('status', 'verified')
            ->first();
    }

    public function getUserByUserEmail($userEmail, $select = ['*'])
    {
        return User::select($select)
            ->where('email', $userEmail)
            ->where('is_active', 1)
            ->where('status', 'verified')
            ->first();
    }

    public function getEmployeeAttendanceDetailOfTheMonth($filterParameter, $select, $with)
    {
        return User::with($with)
            ->select($select)
            ->where('id', $filterParameter['user_id'])
            ->with('employeeAttendance', function ($query) use ($filterParameter) {
                if(isset($filterParameter['start_date'])){
                    $query->whereBetween('attendance_date', [$filterParameter['start_date'],$filterParameter['end_date']]);
                }else{
                    $query->whereMonth('attendance_date', $filterParameter['month'])
                        ->whereYear('attendance_date', $filterParameter['year']);
                }

            })
            ->first();
    }

    public function getEmployeeOverviewDetail($employeeId, $date)
    {
        $totalLeaveAllocated = DB::table('leave_types')
            ->select('company_id', DB::raw('sum(leave_allocated) as total_paid_leaves'))
            ->whereNotNull('leave_allocated')
            ->where('is_active', '1')
            ->groupBy('company_id');

        $presentDays = DB::table('attendances')
            ->select('user_id', 'company_id', DB::raw('COUNT(id) as total_present_day'))
            ->whereNotNull('check_out_at');
        if (isset($date['start_date'])) {
            $presentDays->whereBetween('attendance_date', [$date['start_date'], $date['end_date']]);
        } else {
            $presentDays->whereYear('attendance_date', $date['year']);
        }
        $presentDays->groupBy('user_id', 'company_id');


        $leaveTaken = DB::table('leave_requests_master')
            ->select('requested_by', 'company_id', DB::raw('sum(no_of_days) as total_leave_taken'))
            ->where('status', 'approved');
        if (isset($date['start_date'])) {
            $leaveTaken
                ->whereBetween('leave_from', [$date['start_date'], $date['end_date']])
                ->whereBetween('leave_to', [$date['start_date'], $date['end_date']]);
        } else {
            $leaveTaken
                ->whereYear('leave_from', $date['year'])
                ->whereYear('leave_to', $date['year']);
        }
        $leaveTaken->groupBy('requested_by', 'company_id');


        $pendingLeaves = DB::table('leave_requests_master')
            ->select('requested_by', 'company_id', DB::raw('sum(no_of_days) as total_pending_leaves'))
            ->where('status', 'pending');
        if (isset($date['start_date'])) {
            $pendingLeaves
                ->whereBetween('leave_from', [$date['start_date'], $date['end_date']])
                ->whereBetween('leave_to', [$date['start_date'], $date['end_date']]);
        } else {
            $pendingLeaves
                ->whereYear('leave_from', $date['year'])
                ->whereYear('leave_to', $date['year']);
        }
        $pendingLeaves->groupBy('requested_by', 'company_id');


        $totalHolidays = DB::table('holidays')
            ->select('company_id', DB::raw('COUNT(id) as total_holidays'))
            ->where('is_active', '1');
        if (isset($date['start_date'])) {
            $totalHolidays->whereBetween('event_date', [$date['start_date'], $date['end_date']]);
        } else {
            $totalHolidays->whereYear('event_date', $date['year']);
        }
        $totalHolidays->groupBy('company_id');


        return DB::table('users')->select(
            'present_days.total_present_day',
            'leave_taken.total_leave_taken',
            'holidays.total_holidays',
            'leave_allocated.total_paid_leaves',
            'pending_leaves.total_pending_leaves'
        )
            ->leftJoinSub($presentDays, 'present_days', function ($join) {
                $join->on('users.id', '=', 'present_days.user_id');
            })
            ->leftJoinSub($leaveTaken, 'leave_taken', function ($join) {
                $join->on('users.id', '=', 'leave_taken.requested_by');
            })
            ->leftJoinSub($totalHolidays, 'holidays', function ($join) {
                $join->on('users.company_id', '=', 'holidays.company_id');
            })
            ->leftJoinSub($totalLeaveAllocated, 'leave_allocated', function ($join) {
                $join->on('users.company_id', '=', 'leave_allocated.company_id');
            })
            ->leftJoinSub($pendingLeaves, 'pending_leaves', function ($join) {
                $join->on('users.id', '=', 'pending_leaves.requested_by');
            })
            ->where('users.is_active', 1)
            ->where('users.status', 'verified')
            ->whereNull('users.deleted_at')
            ->where('users.id', $employeeId)
            ->first();
    }

    public function getAllCompanyEmployeeLogOutRequest($companyId, $select = ['*'])
    {
        return User::select($select)
            ->where('logout_status', 1)
            ->where('status', 'verified')
            ->where('is_active', 1)
            ->where('company_id', $companyId)
            ->get();
    }

    public function acceptLogoutRequest($employeeId)
    {
        $userDetail = $this->findUserDetailById($employeeId);
        return $userDetail->update([
            'logout_status' => 0,
        ]);
    }

    public function findUserDetailByRole($id)
    {
        return User::where('role_id', $id)->first();
    }

    public function updateUserFcmToken($userDetail, $newFcmToken)
    {
        return $userDetail->update(['fcm_token' => $newFcmToken]);
    }
}
