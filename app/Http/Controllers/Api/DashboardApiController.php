<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Resources\Dashboard\CompanyWeekendResource;
use App\Resources\Dashboard\EmployeeTodayAttendance;
use App\Resources\Dashboard\EmployeeWeeklyReport;
use App\Resources\Dashboard\OfficeTimeResource;
use App\Resources\Dashboard\OverviewResource;
use App\Resources\Dashboard\UserReportResource;
use App\Resources\User\CompanyResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    private UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function userDashboardDetail(Request $request): JsonResponse
    {
        try {
            $fcmToken =  $request->header('fcm_token');
            $with = [
                'branch:id,name',
                'company:id,name,weekend',
                'post:id,post_name',
                'department:id,dept_name',
                'role:id,name',
                'officeTime',
                'employeeTodayAttendance:user_id,check_in_at,check_out_at,attendance_date',
                'employeeWeeklyAttendance:user_id,check_in_at,check_out_at,attendance_date'
            ];
            $dashboard = [];
            $select = ['users.*', 'branch_id', 'company_id', 'department_id', 'post_id', 'role_id'];
            $date = AppHelper::yearDetailToFilterData();
            $userDetail = $this->userRepo->findUserDetailById(getAuthUserCode(), $select, $with);
            $this->userRepo->updateUserFcmToken($userDetail,$fcmToken);
            $overview = $this->userRepo->getEmployeeOverviewDetail(getAuthUserCode(),$date);
            $dashboard['user'] = new UserReportResource($userDetail);
            $dashboard['employee_today_attendance'] = new EmployeeTodayAttendance($userDetail);
            $dashboard['overview'] = new OverviewResource($overview);
            $dashboard['office_time'] = new OfficeTimeResource($userDetail);
            $dashboard['company'] = new CompanyWeekendResource($userDetail);
            $dashboard['employee_weekly_report'] = new EmployeeWeeklyReport($userDetail);
            $dashboard['date_in_ad'] = !AppHelper::ifDateInBsEnabled();

            return AppHelper::sendSuccessResponse('Data Found', $dashboard);
        } catch (Exception $exception) {
            return AppHelper::sendErrorResponse($exception->getMessage(), 400);
        }
    }

}



