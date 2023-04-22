<?php

namespace App\Helpers;

use App\Models\AppSetting;
use App\Models\Company;
use App\Models\GeneralSetting;
use App\Models\Role;
use App\Models\TaskComment;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AppHelper
{
    const MONTHS = [
        '1' => array(
            'en' => 'Jan',
            'np' => 'वैशाख',
        ),
        '2' => array(
            'en' => 'Feb',
            'np' => 'ज्येष्ठ',
        ),
        '3' => array(
            'en' => 'Mar',
            'np' => 'आषाढ़',
        ),
        '4' => array(
            'en' => 'Apr',
            'np' => 'श्रावण',
        ),
        '5' => array(
            'en' => 'May',
            'np' => 'भाद्र',
        ),
        '6' => array(
            'en' => 'Jun',
            'np' => 'आश्विन',
        ),
        '7' => array(
            'en' => 'Jul',
            'np' => 'कार्तिक',
        ),
        '8' => array(
            'en' => 'Aug',
            'np' => 'मंसिर',
        ),
        '9' => array(
            'en' => 'Sept',
            'np' => 'पौष',
        ),
        '10' => array(
            'en' => 'Oct',
            'np' => 'माघ',
        ),
        '11' => array(
            'en' => 'Nov',
            'np' => 'फाल्गुण',
        ),
        '12' => array(
            'en' => 'Dec',
            'np' => 'चैत्र',
        ),

    ];

    public static function getAuthUserCompanyId() : int
    {
        if(!auth()->user()){
            throw new Exception('unauthenticated',401);
        }
        $user = User::select('company_id')->where('id',Auth::user()->id)->first();
        if(!$user){
            throw new Exception('User Company Id not found',401);
        }
        return  $user?->company_id;
    }

    public static function getCompanyLogo()
    {
        $image = Company::select('logo')->first();
        return $image['logo'];
    }

    public static function getAuthUserRole()
    {
        if(!auth()->user()){
            throw new Exception('unauthenticated',401);
        }
        $user = User::with('role')->select('name','id','role_id')->where('id',Auth::user()->id)->first();
        if(!$user){
            throw new Exception('User not found',401);
        }
        return  $user->role->name;
    }

    public static function findAdminUserAuthId()
    {
        $user = User::with('role')
                ->whereHas('role', function ($query) {
                     $query->where('name' ,'admin');
                })
            ->first();
        if(!$user){
            throw new Exception('User not found',401);
        }
        return  $user->role->id;
    }

    public static function getAuthUserBranchId()
    {
        if(!auth()->user()){
            throw new Exception('unauthenticated',401);
        }
        $user = User::with('role')->select('id','branch_id')->where('id',Auth::user()->id)->first();
        if(!$user){
            throw new Exception('User not found',401);
        }
        return  $user->branch_id;
    }

    public static function check24HoursTimeAppSetting(): bool
    {
        $slug = '24-hour-format';
        $appTimeSetting = AppSetting::where('slug',$slug)->where('status',1)->count();
        return (bool)$appTimeSetting;
    }

    public static function ifDateInBsEnabled(): bool
    {
        $slug = 'bs';
        $appSetting = AppSetting::where('slug',$slug)->where('status',1)->count();
        return (bool)$appSetting;
    }

    public static function getFirebaseServerKey(): mixed
    {
        $generalSettingData =  GeneralSetting::select('value')
            ->where('key','firebase_key')
            ->first();
        return $generalSettingData ? $generalSettingData->value : '';

    }

    public static function sendErrorResponse($message, $code = 500, array $errorFields = null): JsonResponse
    {
        $response = [
            'status' => false,
            'message' => $message,
            'status_code' => $code,
        ];
        if (!is_null($errorFields)) {
            $response['data'] = $errorFields;
        }
        if ($code < 200 || !is_numeric($code) || $code > 599) {
            $code = 500;
            $response['code'] = $code;
        }
        return response()->json($response, $code);
    }

    public static function sendSuccessResponse($message, $data = null, $headers = [], $options = 0): JsonResponse
    {
        $response = [
            'status' => true,
            'message' => $message,
            'status_code' => 200,

        ];
        if (!is_null($data)) {
            $response['data'] = $data;
        }
        return response()->json($response, 200, $headers, $options);
    }

    public static function getProgressBarStyle($progressPercent): string
    {
        $width = 'width: '.$progressPercent.'%;';

        if($progressPercent >= 0 && $progressPercent < 26){
            $color = 'background-color:#C1E1C1';
        }elseif($progressPercent >= 26 && $progressPercent < 51){
            $color = 'background-color:#C9CC3F';
        }elseif ($progressPercent >= 51 && $progressPercent < 76){
            $color = 'background-color: #93C572';
        }else{
            $color = 'background-color:#3cb116';
        }
        return $width.$color;
    }

    public static function convertLeaveDateFormat($dateTime ,$changeEngToNep=true): string
    {
        if(self::check24HoursTimeAppSetting()){
            if(self::ifDateInBsEnabled() && $changeEngToNep){
                $date = self::getDayMonthYearFromDate($dateTime);
                $dateInBs = (new DateConverter())->engToNep($date['year'],$date['month'],$date['day']);
                $time = date('H:i',strtotime($dateTime));
                return $dateInBs['date']. ' '.$dateInBs['nmonth']. ' '.$time;
            }
            return date('M d H:i ', strtotime($dateTime));
        }else{
            if(self::ifDateInBsEnabled() && $changeEngToNep){
                $date = self::getDayMonthYearFromDate($dateTime);
                $dateInBs = (new DateConverter())->engToNep($date['year'],$date['month'],$date['day']);
                $time = date('h:i A',strtotime($dateTime));
                return $dateInBs['date']. ' '.$dateInBs['nmonth']. ' '.$time;
            }
            return date('M d h:i A', strtotime($dateTime));
        }
    }


    public static function getCurrentDateInYmdFormat(): string
    {
        return Carbon::now()->format('Y-m-d');
    }

    public static function getCurrentYear(): string
    {
        return Carbon::now()->format('Y');
    }

    public static function formatDateForView($date, $changeEngToNep=true): string
    {
        if(self::ifDateInBsEnabled() && $changeEngToNep){
            $date = self::getDayMonthYearFromDate($date);
            $dateInBs = (new DateConverter())->engToNep($date['year'],$date['month'],$date['day']);
            return $dateInBs['date'].' '.$dateInBs['nmonth'].' '.$dateInBs['year'];
        }
        return date('d M Y',strtotime($date));
    }

    public static function getFormattedNepaliDate($date): string
    {
        $data = self::getDayMonthYearFromDate($date);
        return  $data['day'].' '.self::MONTHS[$data['month']]['np'].' '.$data['year'];
    }

    public static function dateInYmdFormatNepToEng($date): string
    {
        $date = self::getDayMonthYearFromDate($date);
        $dateInAd = (new DateConverter())->nepToEng($date['year'],$date['month'],$date['day']);
        return $dateInAd['year'].'-'.$dateInAd['month'].'-'.$dateInAd['date'];
    }

    public static function dateInYmdFormatEngToNep($date): string
    {
        $date = self::getDayMonthYearFromDate($date);
        $dateInAd = (new DateConverter())->engToNep($date['year'],$date['month'],$date['day']);
        return $dateInAd['year'].'-'.$dateInAd['month'].'-'.$dateInAd['date'];
    }

    public static function getDayMonthYearFromDate($date): array
    {
        $data['year'] = date('Y', strtotime($date));
        $data['month'] = date('n', strtotime($date));
        $data['day'] = date('d', strtotime($date));
        return $data;
    }

    public static function dateInDDMMFormat($date,$dateEngToNep=true): string
    {
        if($dateEngToNep){
            $date = explode(' ',self::formatDateForView($date));
            return $date[0]. ' '.$date[1];
        }
        return date( 'd M',strtotime($date));
    }

    public static function getCurrentNepaliYearMonth(): array
    {
        return (new DateConverter())->getCurrentMonthAndYearInNepali();
    }

    public static function getTotalDaysInNepaliMonth($year,$month): int
    {
        return (new DateConverter())->getTotalDaysInMonth($year,$month);
    }

    public static function findAdDatesFromNepaliMonthAndYear($year,$month=''): array
    {
        if(!empty($month)){
            return (new DateConverter())->getStartAndEndDateFromGivenNepaliMonth($year,$month);
        }
        return (new DateConverter())->getStartAndEndDateOfYearFromGivenNepaliYear($year);
    }

    public static function yearDetailToFilterData()
    {
        $dateArray = [
            'start_date' => null,
            'end_date' => null,
            'year' => Carbon::now()->format('Y-m-d'),
        ];
        if (self::ifDateInBsEnabled()) {
            $nepaliDate = self::getCurrentNepaliYearMonth();
            $dateInAD = self::findAdDatesFromNepaliMonthAndYear($nepaliDate['year']);
            $dateArray['start_date'] = $dateInAD['start_date'];
            $dateArray['end_date'] = $dateInAD['end_date'];
        }
        return $dateArray;
    }

    public static function getCurrentDateInBS(): string
    {
        return (new DateConverter())->getTodayDateInBS();
    }

    public static function weekDay($date): string
    {
        if(self::ifDateInBsEnabled()){
            $date = self::dateInYmdFormatNepToEng($date);
        }
        return date('D', strtotime($date));
    }

    public static function getFormattedAdDateToBs($englishDate): string
    {
        $date = self::getDayMonthYearFromDate($englishDate);
        $dateInBs = (new DateConverter())->engToNep($date['year'],$date['month'],$date['day']);
        return $dateInBs['date'].' '.$dateInBs['nmonth'].' '.$dateInBs['year'];
    }

    public static function getBsNxtYearEndDateInAd()
    {
        $addYear = 1;
        $nepaliDate = self::getCurrentNepaliYearMonth();
        $dateInAD = self::findAdDatesFromNepaliMonthAndYear($nepaliDate['year']+$addYear);
        return $dateInAD['end_date'];
    }

    public static function getBackendLoginAuthorizedRole()
    {
        if (Cache::has('role')){
            return Cache::get('role');
        } else {
            $roles = [];
            $backendAuthorizedLoginRole = Role::select('slug')->where('backend_login_authorize',1)->get();
            foreach($backendAuthorizedLoginRole as $key => $value){
                $roles[] = $value->slug;
            }
            Cache::forever('role', $roles);
        }
       return $roles;
    }

    public static function getAdminUserId()
    {
        $user =  User::query()->select('id')
            ->whereHas('role',function($subQuery) {
                $subQuery->where('slug', 'admin');
            })->first();
        return $user->id;
    }

}
