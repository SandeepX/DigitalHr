<?php

namespace App\Helpers\SMPush;

use App\Helpers\AppHelper;
use App\Models\User;

class SMPushHelper
{
    public static function getAllCompanyUsersFCMTokens($deviceType): array {
        return User::where('device_type', $deviceType)
            ->where('company_id',AppHelper::getAuthUserCompanyId())
            ->where('is_active',1)
            ->where('status','verified')
            ->whereNotNull('fcm_token')
            ->get()
            ->pluck('fcm_token', 'id')
            ->toArray();
    }

    public static function getAdminFCMTokens($deviceType):array
    {
        return User::where('device_type',$deviceType)
            ->where('company_id',AppHelper::getAuthUserCompanyId())
            ->whereHas('role',function($query){
                $query->where('slug','admin');
            })
            ->where('is_active',1)
            ->where('status','verified')
            ->whereNotNull('fcm_token')
            ->get()
            ->pluck('fcm_token', 'id')
            ->toArray();
    }

    public static function getEmployeeFCMTokensForSending(array $userIds, $deviceType)
    {
        return User::where('device_type', $deviceType)
            ->where('company_id',AppHelper::getAuthUserCompanyId())
            ->where('is_active',1)
            ->where('status','verified')
            ->whereIn('id',$userIds)
            ->whereNotNull('fcm_token')
            ->get()
            ->pluck('fcm_token', 'id')
            ->toArray();
    }

    public static function getUserFCMToken($userId,$deviceType): array
    {
        return User::where('device_type', $deviceType)
            ->where('company_id',AppHelper::getAuthUserCompanyId())
            ->where('id',$userId)
            ->where('is_active',1)
            ->where('status','verified')
            ->whereNotNull('fcm_token')
            ->get()
            ->pluck('fcm_token', 'id')
            ->toArray();
    }

    public static function sendPush(string $title, string $description, array $data=[]): void
    {
        SMPushNotification::smSend(
            isAndroid: true,
            title: $title,
            message: $description,
            type: SMPushNotification::C_TYPE_NOTIFICATION,
            data: [
                'title'=>$title,
                'message'=> $description
            ],
            recipients: self::getAllCompanyUsersFCMTokens(User::ANDROID)
        );

        SMPushNotification::smSend(
            isAndroid: false,
            title: $title,
            message: $description,
            type: SMPushNotification::C_TYPE_NOTIFICATION,
            data: [
                'title'=>$title,
                'message'=> $description
            ],
            recipients: self::getAllCompanyUsersFCMTokens(User::IOS)
        );
    }

    public static function sendLeaveStatusNotification(string $title, string $description,$userId)
    {
         SMPushNotification::smSend(
            isAndroid: true,
            title: $title,
            message: $description,
            type: SMPushNotification::C_TYPE_LEAVE,
            data: [
                'title'=>$title,
                'message'=> $description
            ],
            recipients: self::getUserFCMToken($userId,User::ANDROID)
        );

        SMPushNotification::smSend(
            isAndroid: false,
            title: $title,
            message: $description,
            type: SMPushNotification::C_TYPE_LEAVE,
            data: [
                'title'=>$title,
                'message'=> $description
            ],
            recipients: self::getUserFCMToken($userId,User::IOS)
        );
    }

    public static function sendNotificationToAdmin(string $title, string $description)
    {
        SMPushNotification::smSend(
            isAndroid: true,
            title: $title,
            message: $description,
            type: SMPushNotification::C_TYPE_NORMAL,
            data: [
                'title'=>$title,
                'message'=> $description
            ],
            recipients: self::getAdminFCMTokens(User::ANDROID)
        );

        SMPushNotification::smSend(
            isAndroid: false,
            title: $title,
            message: $description,
            type: SMPushNotification::C_TYPE_NORMAL,
            data: [
                'title'=>$title,
                'message'=> $description
            ],
            recipients: self::getAdminFCMTokens(User::IOS)
        );
    }

    public static function sendNoticeNotification(string $title,
                                                  string $description,
                                                  array $userIds,
                                                  bool $teamMeeting = false,
                                                  $id=''
    ): void
    {
        SMPushNotification::smSend(
            isAndroid: true,
            title: $title,
            message: $description,
            type: $teamMeeting ? SMPushNotification::C_TYPE_TEAM_MEETING : SMPushNotification::C_TYPE_NOTICE  ,
            data: [
                'title'=>$title,
                'message'=> $description,
                'id'=> $id
            ],
            recipients: self::getEmployeeFCMTokensForSending($userIds,User::ANDROID)
        );

        SMPushNotification::smSend(
            isAndroid: false,
            title: $title,
            message: $description,
            type: $teamMeeting ? SMPushNotification::C_TYPE_TEAM_MEETING : SMPushNotification::C_TYPE_NOTICE  ,
            data: [
                'title'=>$title,
                'message'=> $description,
                'id'=> $id
            ],
            recipients: self::getEmployeeFCMTokensForSending($userIds,User::IOS)
        );
    }

    public static function sendSupportNotification(string $title,
                                                  string $description,
                                                  array $userIds,
                                                         $id=''
    ): void
    {
        SMPushNotification::smSend(
            isAndroid: true,
            title: $title,
            message: $description,
            type: SMPushNotification::C_TYPE_SUPPORT,
            data: [
                'title'=>$title,
                'message'=> $description,
                'id'=> $id
            ],
            recipients: self::getEmployeeFCMTokensForSending($userIds,User::ANDROID)
        );

        SMPushNotification::smSend(
            isAndroid: false,
            title: $title,
            message: $description,
            type: SMPushNotification::C_TYPE_SUPPORT ,
            data: [
                'title'=>$title,
                'message'=> $description,
                'id'=> $id
            ],
            recipients: self::getEmployeeFCMTokensForSending($userIds,User::IOS)
        );
    }

    public static function sendProjectManagementNotification(string $title,
                                                   string $description,
                                                   array $userIds,
                                                          $id=''
    ): void
    {
        SMPushNotification::smSend(
            isAndroid: true,
            title: $title,
            message: $description,
            type: SMPushNotification::C_TYPE_PROJECT_MANAGEMENT,
            data: [
                'title'=>$title,
                'message'=> $description,
                'id'=> $id
            ],
            recipients: self::getEmployeeFCMTokensForSending($userIds,User::ANDROID)
        );

        SMPushNotification::smSend(
            isAndroid: false,
            title: $title,
            message: $description,
            type: SMPushNotification::C_TYPE_PROJECT_MANAGEMENT,
            data: [
                'title'=>$title,
                'message'=> $description,
                'id'=> $id
            ],
            recipients: self::getEmployeeFCMTokensForSending($userIds,User::IOS)
        );
    }




}
