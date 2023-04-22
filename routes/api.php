<?php

use App\Http\Controllers\Api\AttendanceApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\EmployeeLeaveApiController;
use App\Http\Controllers\Api\HolidayApiController;
use App\Http\Controllers\Api\LeaveApiController;
use App\Http\Controllers\Api\LeaveTypeApiController;
use App\Http\Controllers\Api\NoticeApiController;
use App\Http\Controllers\Api\NotificationApiController;
use App\Http\Controllers\Api\ProjectApiController;
use App\Http\Controllers\Api\ProjectManagementDashboardApiController;
use App\Http\Controllers\Api\StaticPageContentApiController;
use App\Http\Controllers\Api\SupportApiController;
use App\Http\Controllers\Api\TadaApiController;
use App\Http\Controllers\Api\TaskApiController;
use App\Http\Controllers\Api\TaskChecklistApiController;
use App\Http\Controllers\Api\TaskCommentApiController;
use App\Http\Controllers\Api\TeamMeetingApiController;
use App\Http\Controllers\Api\UserProfileApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthApiController;

/**   user login **/
Route::post('login', [AuthApiController::class,'login']);

Route::get('team-meetings/{id}', [TeamMeetingApiController::class, 'findTeamMeetingDetail']);
Route::group([
    'middleware' => ['auth:api']
], function () {

    /**   user logout **/
    Route::get('logout', [AuthApiController::class, 'logout'])->name('user.logout');

    /** Users Routes **/
    Route::get('users/profile', [UserProfileApiController::class, 'userProfileDetail'])->name('users.profile');
    Route::post('users/change-password', [UserProfileApiController::class, 'changePassword'])->name('users.change-password');
    Route::post('users/update-profile', [UserProfileApiController::class, 'updateUserProfile'])->name('users.update-profile');
    Route::get('users/profile-detail/{userId}', [UserProfileApiController::class, 'findEmployeeDetailById']);
    Route::get('users/company/team-sheet', [UserProfileApiController::class, 'getTeamSheetOfCompany'])->name('users.company.team-sheet');

    /** content management Routes **/
    Route::get('static-page-content/{contentType}', [StaticPageContentApiController::class, 'getStaticPageContentByContentType']);
    Route::get('company-rules', [StaticPageContentApiController::class, 'getCompanyRulesDetail']);
    Route::get('static-page-content/{contentType}/{titleSlug}', [StaticPageContentApiController::class, 'getStaticPageContentByContentTypeAndTitleSlug']);

    /** notifications Routes **/
    Route::get('notifications', [NotificationApiController::class, 'getAllRecentPublishedNotification']);

    /** notice Routes **/
    Route::get('notices', [NoticeApiController::class, 'getAllRecentlyReceivedNotice']);

    /** Dashboard Routes **/
    Route::get('dashboard', [DashboardApiController::class, 'userDashboardDetail']);

    /** Attendance Routes **/
    Route::post('employees/check-in', [AttendanceApiController::class, 'employeeCheckIn']);
    Route::post('employees/check-out', [AttendanceApiController::class, 'employeeCheckOut']);
    Route::get('employees/attendance-detail', [AttendanceApiController::class, 'getEmployeeAllAttendanceDetailOfTheMonth']);

    /** Leave Request Routes **/
    Route::get('leave-types', [LeaveTypeApiController::class, 'getAllLeaveTypeWithEmployeeLeaveRecord']);
    Route::post('leave-requests/store', [LeaveApiController::class, 'saveLeaveRequestDetail']);
    Route::get('leave-requests/employee-leave-requests', [LeaveApiController::class, 'getAllLeaveRequestOfEmployee']);
    Route::get('leave-requests/employee-leave-calendar', [LeaveApiController::class, 'getLeaveCountDetailOfEmployeeOfTwoMonth']);
    Route::get('leave-requests/employee-leave-list', [LeaveApiController::class, 'getAllEmployeeLeaveDetailBySpecificDay']);

    /** Team Meeting Routes **/
    Route::get('team-meetings', [TeamMeetingApiController::class, 'getAllAssignedTeamMeetingDetail']);

    /** Holiday route */
    Route::get('holidays', [HolidayApiController::class, 'getAllActiveHoliday'])->name('holiday.getAllHolidays');

    /** Project Management Dashboard route */
    Route::get('project-management-dashboard', [ProjectManagementDashboardApiController::class, 'getUserProjectManagementDashboardDetail']);

    /** Project route */
    Route::get('assigned-projects-list', [ProjectApiController::class, 'getUserAssignedAllProjects']);
    Route::get('assigned-projects-detail/{projectId}', [ProjectApiController::class, 'getProjectDetailById']);

    /** Tasks route */
    Route::get('assigned-task-list', [TaskApiController::class, 'getUserAssignedAllTasks']);
    Route::get('assigned-task-detail/{taskId}', [TaskApiController::class, 'getTaskDetailById']);
    Route::get('assigned-task-detail/change-status/{taskId}', [TaskApiController::class, 'changeTaskStatus']);
    Route::get('assigned-task-comments', [TaskApiController::class, 'getTaskComments']);

    /** Task checklist route */
    Route::get('assigned-task-checklist/toggle-status/{checklistId}', [TaskChecklistApiController::class, 'toggleCheckListIsCompletedStatus']);

    /** Task Comment route */
    Route::post('assigned-task/comments/store', [TaskCommentApiController::class, 'saveComment']);
    Route::get('assigned-task/comment/delete/{commentId}', [TaskCommentApiController::class, 'deleteComment']);
    Route::get('assigned-task/reply/delete/{replyId}', [TaskCommentApiController::class, 'deleteReply']);

    /** Support route */
    Route::post('support/query-store', [SupportApiController::class, 'store']);

    /** Tada route */
    Route::get('employee/tada-lists', [TadaApiController::class, 'getEmployeesTadaLists']);
    Route::get('employee/tada-details/{tadaId}', [TadaApiController::class, 'getEmployeesTadaDetail']);
    Route::post('employee/tada/store', [TadaApiController::class, 'storeTadaDetail']);
    Route::put('employee/tada/update/{tadaId}', [TadaApiController::class, 'updateTadaDetail']);
    Route::get('employee/tada/delete-attachment/{attachmentId}', [TadaApiController::class, 'deleteTadaAttachment']);

});


