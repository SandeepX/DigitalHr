<?php

namespace App\Helpers;

class RolePermissionHelper
{
    public static function permissionModuleArray(): array
    {
        return [
            [//1
                "name" => "Role",
            ],
            [//2
                "name" => "Company",
            ],
            [//3
                "name" => "Branch",
            ],
            [//4
                "name" => "Department",
            ],
            [//5
                "name" => "Post",
            ],
            [//6
                "name" => "Employee",
            ],
            [//7
                "name" => "Setting",
            ],
            [//8
                "name" => "Attendance",
            ],
            [//9
                "name" => "Leave",
            ],
            [//10
                "name" => "Holiday",
            ],
            [//11
                "name" => "Notice",
            ],
            [//12
                "name" => "Team Meeting",
            ],
            [//13
                "name" => "Content Management",
            ],
            [//14
                "name" => "Shift Management",
            ],
            [//15
                "name" => "Notification",
            ],
            [//16
                "name" => "Support"
            ],
            [//17
                "name" => "Tada"
            ],
            [//18
                "name" => "Client"
            ],
            [//19
                "name" => "Project Management"
            ],
            [//20
                "name" => "Task Management"
            ],

        ];
    }

    public static function permissionArray(): array
    {
        return [
            /** Role Permissions */
            [
                "name" => "List Role",
                "permission_key" => "list_role",
                "permission_groups_id" => 1
            ],
            [
                "name" => "Create Role",
                "permission_key" => "create_role",
                "permission_groups_id" => 1
            ],
            [
                "name" => "Edit Role",
                "permission_key" => "edit_role",
                "permission_groups_id" => 1
            ],
            [
                "name" => "Delete Role",
                "permission_key" => "delete_role",
                "permission_groups_id" => 1
            ],
            [
                "name" => "List Permission",
                "permission_key" => "list_permission",
                "permission_groups_id" => 1
            ],
            [
                "name" => "Assign Permission",
                "permission_key" => "assign_permission",
                "permission_groups_id" => 1
            ],

            /** Company Permissions */
            [
                "name" => "View Company",
                "permission_key" => "view_company",
                "permission_groups_id" => 2
            ],
            [
                "name" => "Create Company",
                "permission_key" => "create_company",
                "permission_groups_id" => 2
            ],
            [
                "name" => "Edit Company",
                "permission_key" => "edit_company",
                "permission_groups_id" => 2
            ],

            /** Branch Permissions */
            [
                "name" => "List Branch",
                "permission_key" => "list_branch",
                "permission_groups_id" => 3
            ],
            [
                "name" => "Create Branch",
                "permission_key" => "create_branch",
                "permission_groups_id" => 3
            ],
            [
                "name" => "Edit Branch",
                "permission_key" => "edit_branch",
                "permission_groups_id" => 3
            ],
            [
                "name" => "Delete Branch",
                "permission_key" => "delete_branch",
                "permission_groups_id" => 3
            ],

            /** Department Permissions */
            [
                "name" => "List Department",
                "permission_key" => "list_department",
                "permission_groups_id" => 4
            ],
            [
                "name" => "Create Department",
                "permission_key" => "create_department",
                "permission_groups_id" => 4
            ],
            [
                "name" => "Edit Department",
                "permission_key" => "edit_department",
                "permission_groups_id" => 4
            ],
            [
                "name" => "Delete Department",
                "permission_key" => "delete_department",
                "permission_groups_id" => 4
            ],

            /** Post Permissions */
            [
                "name" => "List Post",
                "permission_key" => "list_post",
                "permission_groups_id" => 5
            ],
            [
                "name" => "Create Post",
                "permission_key" => "create_post",
                "permission_groups_id" => 5
            ],
            [
                "name" => "Edit Post",
                "permission_key" => "edit_post",
                "permission_groups_id" => 5
            ],
            [
                "name" => "Delete Post",
                "permission_key" => "delete_post",
                "permission_groups_id" => 5
            ],

            /** Employee Management Permissions */
            [
                "name" => "List Employee",
                "permission_key" => "list_employee",
                "permission_groups_id" => 6
            ],
            [
                "name" => "Create Employee",
                "permission_key" => "create_employee",
                "permission_groups_id" => 6
            ],
            [
                "name" => "Show Detail Employee",
                "permission_key" => "show_detail_employee",
                "permission_groups_id" => 6
            ],
            [
                "name" => "Edit Employee",
                "permission_key" => "edit_employee",
                "permission_groups_id" => 6
            ],
            [
                "name" => "Delete Employee",
                "permission_key" => "delete_employee",
                "permission_groups_id" => 6
            ],
            [
                "name" => "Change Password",
                "permission_key" => "change_password",
                "permission_groups_id" => 6
            ],
            [
                "name" => "Force Logout Employee",
                "permission_key" => "force_logout",
                "permission_groups_id" => 6
            ],
            [
                "name" => "List Logout Request",
                "permission_key" => "list_logout_request",
                "permission_groups_id" => 6
            ],
            [
                "name" => "Logout Request Accept",
                "permission_key" => "accept_logout_request",
                "permission_groups_id" => 6
            ],

            /** Setting Permissions */
            [
                "name" => "List Router",
                "permission_key" => "list_router",
                "permission_groups_id" => 7
            ],
            [
                "name" => "Create Router",
                "permission_key" => "create_router",
                "permission_groups_id" => 7
            ],
            [
                "name" => "Edit Router",
                "permission_key" => "edit_router",
                "permission_groups_id" => 7
            ],
            [
                "name" => "Delete Router",
                "permission_key" => "delete_router",
                "permission_groups_id" => 7
            ],
            [
                "name" => "List General Setting",
                "permission_key" => "list_general_setting",
                "permission_groups_id" => 7
            ],
            [
                "name" => "General Setting Update",
                "permission_key" => "general_setting_update",
                "permission_groups_id" => 7
            ],
            [
                "name" => "List App Setting",
                "permission_key" => "list_app_setting",
                "permission_groups_id" => 7
            ],
            [
                "name" => "Update App Setting",
                "permission_key" => "update_app_setting",
                "permission_groups_id" => 7
            ],

            /** Attendance Permissions */
            [
                "name" => "List Attendance",
                "permission_key" => "list_attendance",
                "permission_groups_id" => 8
            ],
            [
                "name" => "Attendance CSV Export",
                "permission_key" => "attendance_csv_export",
                "permission_groups_id" => 8
            ],
            [
                "name" => "Attendance Create",
                "permission_key" => "attendance_create",
                "permission_groups_id" => 8
            ],
            [
                "name" => "Attendance Update",
                "permission_key" => "attendance_update",
                "permission_groups_id" => 8
            ],
            [
                "name" => "Attendance Show",
                "permission_key" => "attendance_show",
                "permission_groups_id" => 8
            ],
            [
                "name" => "Attendance Delete",
                "permission_key" => "attendance_delete",
                "permission_groups_id" => 8
            ],

            /** Leave Permissions */
            [
                "name" => "List Leave Type",
                "permission_key" => "list_leave_type",
                "permission_groups_id" => 9
            ],
            [
                "name" => "Leave Type Create",
                "permission_key" => "leave_type_create",
                "permission_groups_id" => 9
            ],
            [
                "name" => "Leave Type Edit",
                "permission_key" => "leave_type_edit",
                "permission_groups_id" => 9
            ],
            [
                "name" => "Leave Type Delete",
                "permission_key" => "leave_type_delete",
                "permission_groups_id" => 9
            ],
            [
                "name" => "List Leave Requests",
                "permission_key" => "list_leave_request",
                "permission_groups_id" => 9
            ],
            [
                "name" => "Show Leave Request Detail",
                "permission_key" => "show_leave_request_detail",
                "permission_groups_id" => 9
            ],
            [
                "name" => "Update Leave request",
                "permission_key" => "update_leave_request",
                "permission_groups_id" => 9
            ],

            /** Holiday Permissions */
            [
                "name" => "List Holiday",
                "permission_key" => "list_holiday",
                "permission_groups_id" => 10
            ],
            [
                "name" => "Holiday Create",
                "permission_key" => "create_holiday",
                "permission_groups_id" => 10
            ],
            [
                "name" => "Show Detail",
                "permission_key" => "show_holiday",
                "permission_groups_id" => 10
            ],
            [
                "name" => "Holiday Edit",
                "permission_key" => "edit_holiday",
                "permission_groups_id" => 10
            ],
            [
                "name" => "Holiday Delete",
                "permission_key" => "delete_holiday",
                "permission_groups_id" => 10
            ],
            [
                "name" => "Csv Import Holiday",
                "permission_key" => "import_holiday",
                "permission_groups_id" => 10
            ],

            /** Notice Permissions */
            [
                "name" => "List Notice",
                "permission_key" => "list_notice",
                "permission_groups_id" => 11
            ],
            [
                "name" => "Notice Create",
                "permission_key" => "create_notice",
                "permission_groups_id" => 11
            ],
            [
                "name" => "Show Notice Detail",
                "permission_key" => "show_notice",
                "permission_groups_id" => 11
            ],
            [
                "name" => "Notice Edit",
                "permission_key" => "edit_notice",
                "permission_groups_id" => 11
            ],
            [
                "name" => "Notice Delete",
                "permission_key" => "delete_notice",
                "permission_groups_id" => 11
            ],
            [
                "name" => "Send Notice",
                "permission_key" => "send_notice",
                "permission_groups_id" => 11
            ],

            /** Team Meeting Permissions */
            [
                "name" => "List Team Meeting",
                "permission_key" => "list_team_meeting",
                "permission_groups_id" => 12
            ],
            [
                "name" => "Team Meeting Create",
                "permission_key" => "create_team_meeting",
                "permission_groups_id" => 12
            ],
            [
                "name" => "Show Team Meeting Detail",
                "permission_key" => "show_team_meeting",
                "permission_groups_id" => 12
            ],
            [
                "name" => "Team Meeting Edit",
                "permission_key" => "edit_team_meeting",
                "permission_groups_id" => 12
            ],
            [
                "name" => "Team Meeting Delete",
                "permission_key" => "delete_team_meeting",
                "permission_groups_id" => 12
            ],

            /** Content management Permissions */
            [
                "name" => "List Content",
                "permission_key" => "list_content",
                "permission_groups_id" => 13
            ],
            [
                "name" => "Content Create",
                "permission_key" => "create_content",
                "permission_groups_id" => 13
            ],
            [
                "name" => "Show Content Detail",
                "permission_key" => "show_content",
                "permission_groups_id" => 13
            ],
            [
                "name" => "Content Edit",
                "permission_key" => "edit_content",
                "permission_groups_id" => 13
            ],
            [
                "name" => "Content Delete",
                "permission_key" => "delete_content",
                "permission_groups_id" => 13
            ],

            /** Shift management Permissions */
            [
                "name" => "List Office Time",
                "permission_key" => "list_office_time",
                "permission_groups_id" => 14
            ],
            [
                "name" => "Office Time Create",
                "permission_key" => "create_office_time",
                "permission_groups_id" => 14
            ],
            [
                "name" => "Show Office Time Detail",
                "permission_key" => "show_office_time",
                "permission_groups_id" => 14
            ],
            [
                "name" => "Office Time Edit",
                "permission_key" => "edit_office_time",
                "permission_groups_id" => 14
            ],
            [
                "name" => "Office Time Delete",
                "permission_key" => "delete_office_time",
                "permission_groups_id" => 14
            ],

            /** Notification Permissions */
            [
                "name" => "List Notification",
                "permission_key" => "list_notification",
                "permission_groups_id" => 15
            ],
            [
                "name" => "Notification Create",
                "permission_key" => "create_notification",
                "permission_groups_id" => 15
            ],
            [
                "name" => "Show Notification Detail",
                "permission_key" => "show_notification",
                "permission_groups_id" => 15
            ],
            [
                "name" => "Notification Edit",
                "permission_key" => "edit_notification",
                "permission_groups_id" => 15
            ],
            [
                "name" => "Notification Delete",
                "permission_key" => "delete_notification",
                "permission_groups_id" => 15
            ],
            [
                "name" => "Send Notification",
                "permission_key" => "send_notification",
                "permission_groups_id" => 15
            ],

            /** Support Permissions */
            [
                "name" => "View Query List",
                "permission_key" => "view_query_list",
                "permission_groups_id" => 16
            ],
            [
                "name" => "Show Query Detail",
                "permission_key" => "show_query_detail",
                "permission_groups_id" => 16
            ],
            [
                "name" => "Update Status",
                "permission_key" => "update_query_status",
                "permission_groups_id" => 16
            ],
            [
                "name" => "Delete Query",
                "permission_key" => "delete_query",
                "permission_groups_id" => 16
            ],

            /** Tada Permissions */
            [
                "name" => "View Tada List",
                "permission_key" => "view_tada_list",
                "permission_groups_id" => 17
            ],
            [
                "name" => "Create Tada ",
                "permission_key" => "create_tada",
                "permission_groups_id" => 17
            ],
            [
                "name" => "Show Tada Detail",
                "permission_key" => "show_tada_detail",
                "permission_groups_id" => 17
            ],
            [
                "name" => "Edit Tada",
                "permission_key" => "edit_tada",
                "permission_groups_id" => 17
            ],
            [
                "name" => "Delete Tada",
                "permission_key" => "delete_tada",
                "permission_groups_id" => 17
            ],
            [
                "name" => "Upload Attachment ",
                "permission_key" => "create_attachment",
                "permission_groups_id" => 17
            ],
            [
                "name" => "Delete Attachment ",
                "permission_key" => "delete_attachment",
                "permission_groups_id" => 17
            ],

            /** Client Permissions */
            [
                "name" => "View Client List",
                "permission_key" => "view_client_list",
                "permission_groups_id" => 18
            ],
            [
                "name" => "Create Client ",
                "permission_key" => "create_client",
                "permission_groups_id" => 18
            ],
            [
                "name" => "Show Client Detail",
                "permission_key" => "show_client_detail",
                "permission_groups_id" => 18
            ],
            [
                "name" => "Edit Client",
                "permission_key" => "edit_client",
                "permission_groups_id" => 18
            ],
            [
                "name" => "Delete Client",
                "permission_key" => "delete_client",
                "permission_groups_id" => 18
            ],

            /** Project management Permissions */
            [
                "name" => "View Project List",
                "permission_key" => "view_project_list",
                "permission_groups_id" => 19
            ],
            [
                "name" => "Create Project",
                "permission_key" => "create_project",
                "permission_groups_id" => 19
            ],
            [
                "name" => "Show Project Detail",
                "permission_key" => "show_project_detail",
                "permission_groups_id" => 19
            ],
            [
                "name" => "Edit Project",
                "permission_key" => "edit_project",
                "permission_groups_id" => 19
            ],
            [
                "name" => "Delete Project",
                "permission_key" => "delete_project",
                "permission_groups_id" => 19
            ],
            [
                "name" => "Upload Project Attachment",
                "permission_key" => "upload_project_attachment",
                "permission_groups_id" => 19
            ],
            [
                "name" => "Delete PM Attachment",
                "permission_key" => "delete_pm_attachment",
                "permission_groups_id" => 19
            ],

            /** Task management Permissions */
            [
                "name" => "View Task List",
                "permission_key" => "view_task_list",
                "permission_groups_id" => 20
            ],
            [
                "name" => "Create Task",
                "permission_key" => "create_task",
                "permission_groups_id" => 20
            ],
            [
                "name" => "Show Task Detail",
                "permission_key" => "show_task_detail",
                "permission_groups_id" => 20
            ],
            [
                "name" => "Edit Task",
                "permission_key" => "edit_task",
                "permission_groups_id" => 20
            ],
            [
                "name" => "Delete Task",
                "permission_key" => "delete_task",
                "permission_groups_id" => 20
            ],
            [
                "name" => "Upload Task Attachment",
                "permission_key" => "upload_task_attachment",
                "permission_groups_id" => 20
            ],
            [
                "name" => "Create Checklist",
                "permission_key" => "create_checklist",
                "permission_groups_id" => 20
            ],
            [
                "name" => "Edit Checklist",
                "permission_key" => "edit_checklist",
                "permission_groups_id" => 20
            ],
            [
                "name" => "Delete Checklist",
                "permission_key" => "delete_checklist",
                "permission_groups_id" => 20
            ],
            [
                "name" => "Create Comment",
                "permission_key" => "create_comment",
                "permission_groups_id" => 20
            ],
            [
                "name" => "Delete Comment",
                "permission_key" => "delete_comment",
                "permission_groups_id" => 20
            ],
        ];
    }

}
