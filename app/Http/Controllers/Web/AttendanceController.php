<?php

namespace App\Http\Controllers\Web;

use App\Exports\AttendanceDayWiseExport;
use App\Exports\AttendanceExport;
use App\Helpers\AppHelper;
use App\Helpers\AttendanceHelper;
use App\Helpers\SMPush\SMPushHelper;
use App\Http\Controllers\Controller;
use App\Repositories\BranchRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\RouterRepository;
use App\Repositories\UserRepository;
use App\Requests\Attendance\AttendanceTimeEditRequest;
use App\Services\Attendance\AttendanceService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class AttendanceController extends Controller
{
    private $view = 'admin.attendance.';

    private CompanyRepository $companyRepo;
    private AttendanceService $attendanceService;
    private RouterRepository $routerRepo;
    private UserRepository $userRepository;
    private BranchRepository $branchRepo;


    public function __construct(CompanyRepository $companyRepo,
                                AttendanceService $attendanceService,
                                RouterRepository  $routerRepo,
                                UserRepository $userRepository,
                                BranchRepository $branchRepo,
    )
    {
        $this->attendanceService = $attendanceService;
        $this->companyRepo = $companyRepo;
        $this->routerRepo = $routerRepo;
        $this->userRepository =  $userRepository;
        $this->branchRepo =  $branchRepo;
    }

    public function index(Request $request)
    {
        $this->authorize('list_attendance');
        try {
            $selectBranch = ['id','name'];
            $companyId = AppHelper::getAuthUserCompanyId();
            $filterParameter = [
                'attendance_date' => $request->attendance_date ?? AppHelper::getCurrentDateInYmdFormat(),
                'company_id' => $companyId,
                'branch_id' => $request->branch_id ?? null,
                'download_excel' => $request->download_excel,
                'date_in_bs' => false,
            ];
            if(AppHelper::ifDateInBsEnabled()){
                $filterParameter['attendance_date'] = $request->attendance_date ?? AppHelper::getCurrentDateInBS();
                $filterParameter['date_in_bs'] = true;
            }
            $attendanceDetail = $this->attendanceService->getAllCompanyEmployeeAttendanceDetailOfTheDay($filterParameter);
            $branch = $this->branchRepo->getLoggedInUserCompanyBranches($companyId,$selectBranch);
            if($filterParameter['download_excel']){
                return \Maatwebsite\Excel\Facades\Excel::download( new AttendanceDayWiseExport($attendanceDetail,$filterParameter),'attendance-'.$filterParameter['attendance_date'].'-report.xlsx');
            }
            return view($this->view . 'index', compact('attendanceDetail', 'filterParameter','branch'));
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function checkInEmployee($companyId, $userId): RedirectResponse
    {
        $this->authorize('create_attendance');
        try {
            $userDetail = $this->userRepository->findUserDetailById($userId,['name']);
            $validatedData = $this->prepareDataForAttendanceByAdmin($companyId, $userId,'checkIn');
            DB::beginTransaction();
                $checkInAttendance =  $this->attendanceService->employeeCheckIn($validatedData);
            DB::commit();
            $this->attendanceByAdminNotification(
                'Check In Notification',
                ucfirst($userDetail->name). ' checked in at  '. AttendanceHelper::changeTimeFormatForAttendanceView($checkInAttendance->check_in_at)
            );
            return redirect()->back()->with('success', 'Employee Check In Successful');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function checkOutEmployee($companyId, $userId): RedirectResponse
    {
        $this->authorize('attendance_update');
        try {
            $userDetail = $this->userRepository->findUserDetailById($userId,['name']);
            $validatedData = $this->prepareDataForAttendanceByAdmin($companyId, $userId,'checkout');
            DB::beginTransaction();
            $attendanceCheckOut = $this->attendanceService->employeeCheckOut($validatedData);
            DB::commit();
            $this->attendanceByAdminNotification(
                'Check Out Notification',
                ucfirst($userDetail->name). ' checked out at '. AttendanceHelper::changeTimeFormatForAttendanceView($attendanceCheckOut->check_out_at)
            );
            return redirect()->back()->with('success', 'Employee Check Out Successful');
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    private function prepareDataForAttendanceByAdmin($companyId, $userId,$checkStatus): array|RedirectResponse
    {
        try {
            $with = ['branch:id,branch_location_latitude,branch_location_longitude'];
            $select = ['routers.*'];
            $routerDetail = $this->routerRepo->findRouterDetailByBranchId(AppHelper::getAuthUserBranchId(),$with,$select);
            if (!$routerDetail) {
                throw new Exception('Branch Routers Detail Not Found.',400);
            }
            if($checkStatus== 'checkIn'){
                $validatedData['check_in_latitude'] = $routerDetail->branch->branch_location_latitude;
                $validatedData['check_in_longitude'] = $routerDetail->branch->branch_location_longitude;

            }else{
                $validatedData['check_out_latitude'] = $routerDetail->branch->branch_location_latitude;
                $validatedData['check_out_longitude'] = $routerDetail->branch->branch_location_longitude;
            }
            $validatedData['user_id'] = $userId;
            $validatedData['company_id'] = $companyId;
            $validatedData['router_bssid'] = $routerDetail->router_ssid;
            return $validatedData;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function changeAttendanceStatus($id): RedirectResponse
    {
        $this->authorize('attendance_update');
        try {
            DB::beginTransaction();
            $this->attendanceService->changeAttendanceStatus($id);
            DB::commit();
            return redirect()->back()->with('success', 'Attendance status changed successful');
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function update(AttendanceTimeEditRequest $request,$id)
    {
        $this->authorize('attendance_update');
        try {
            $validatedData = $request->validated();
            $attendanceDetail = $this->attendanceService->findAttendanceDetailById($id);

            $with = ['branch:id,branch_location_latitude,branch_location_longitude'];
            $select = ['routers.*'];
            $routerDetail = $this->routerRepo->findRouterDetailByBranchId(AppHelper::getAuthUserBranchId(), $with, $select);
            if ($validatedData['check_out_at']){
                $validatedData['check_out_latitude'] = $routerDetail->branch->branch_location_latitude;
                $validatedData['check_out_longitude'] = $routerDetail->branch->branch_location_longitude;
            }
            DB::beginTransaction();
                $this->attendanceService->update($attendanceDetail,$validatedData);
            DB::commit();
            return redirect()->back()->with('success', 'Employee Attendance Edited Successfully');
        }catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function show(Request $request,$employeeId)
    {
        $this->authorize('attendance_show');
        try {
            $filterParameter = [
                'year' => $request->year ?? now()->format('Y'),
                'month' => $request->month ?? now()->month,
                'user_id' => $employeeId,
                'download_excel' => $request->get('download_excel')? true : false,
                'date_in_bs' => false,
            ];
            if(AppHelper::ifDateInBsEnabled()){
                $nepaliDate = AppHelper::getCurrentNepaliYearMonth();
                $filterParameter['year'] = $request->year ?? $nepaliDate['year'];
                $filterParameter['month'] = $request->month ?? $nepaliDate['month'];
                $filterParameter['date_in_bs'] = true;
            }

            $months = AppHelper::MONTHS;
            $userDetail = $this->userRepository->findUserDetailById($employeeId,['id','name']);
            $attendanceDetail = $this->attendanceService->getEmployeeAttendanceDetailOfTheMonth($filterParameter);
            if($filterParameter['download_excel']){
                if($filterParameter['date_in_bs']){
                    $month = \App\Helpers\AppHelper::MONTHS[date("n", strtotime($attendanceDetail[0]['attendance_date']))]['np'];
                }else{
                    $month = date("F", strtotime($attendanceDetail[0]['attendance_date']));
                }
                return \Maatwebsite\Excel\Facades\Excel::download(new AttendanceExport($attendanceDetail,$userDetail),'attendance-'.$userDetail->name.'-'.$filterParameter['year'].'-'. $month.'-report.xlsx');
            }
            return view($this->view.'show',compact('attendanceDetail',
                'filterParameter',
                'months',
                'userDetail')
            );
        }catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function delete($id)
    {
        $this->authorize('attendance_delete');
        $this->attendanceService->delete($id);
        return redirect()->back()->with('success', 'Attendance Deleted Successful');
    }

    private function attendanceByAdminNotification($title, $message)
    {
        SMPushHelper::sendNotificationToAdmin($title, $message);
    }

}
