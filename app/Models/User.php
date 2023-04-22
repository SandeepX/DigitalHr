<?php

namespace App\Models;

use App\Helpers\AppHelper;
use App\Helpers\AttendanceHelper;
use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'address',
        'dob',
        'gender',
        'phone',
        'status',
        'is_active',
        'avatar',
        'leave_allocated',
        'employment_type',
        'user_type',
        'joining_date',
        'workspace_type',
        'salary',
        'remarks',
        'bank_name',
        'bank_account_no',
        'bank_account_type',
        'uuid',
        'fcm_token',
        'device_type',
        'logout_status',
        'company_id',
        'online_status',
        'branch_id',
        'department_id',
        'post_id',
        'role_id',
        'supervisor_id',
        'office_time_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    const AVATAR_UPLOAD_PATH = 'uploads/user/avatar/';

    const RECORDS_PER_PAGE = 20;

    const GENDER = ['male','female','others'];
    const STATUS = ['pending','verified','rejected','suspended'];
    const EMPLOYMENT_TYPE = ['contract','permanent','temporary'];
    const USER_TYPE = ['field','nonField'];

    const DEVICE_TYPE = ['android','ios','web'];

    const ANDROID = 'android';
    const IOS = 'ios';
    const WEB = 'web';

    const ONLINE = 1;

    const OFFLINE = 0;

    const HOME = 0;
    const OFFICE = 1;

    const DEMO_USERS_USERNAME = ['admin123','employee1'];

    const BANK_ACCOUNT_TYPE = ['saving','current','salary'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

//        static::creating(function ($model) {
//            $model->created_by = Auth::user()->id;
//        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id ?? AppHelper::findAdminUserAuthId() ;
        });

        static::deleting(function ($model){
            $model->deleted_by = Auth::user()->id;
        });
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id')->select('name','id','slug');
    }

    public function officeTime(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OfficeTime::class, 'office_time_id', 'id')->select('id','opening_time','closing_time','shift');
    }

    public function employeeAttendance(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Attendance::class,'user_id','id');
    }

    public function employeeTodayAttendance(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Attendance::class,'user_id','id')
            ->where('attendance_date',Carbon::now()->format('Y-m-d'));
    }

    public function employeeWeeklyAttendance(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        $currentDate = Carbon::now();
        $weekStartDate = AttendanceHelper::getStartOfWeekDate($currentDate);
        $weekEndDate = AttendanceHelper::getEndOfWeekDate($currentDate);
        return $this->hasMany(Attendance::class,'user_id','id')
            ->where('attendance_status',1)
//            ->whereNotNull('check_out_at')
            ->whereBetween('attendance_date', [$weekStartDate, $weekEndDate])
            ->orderBy('attendance_date','ASC');
    }

}
