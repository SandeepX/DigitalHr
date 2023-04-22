

<div class="row">
    <div class="col-lg-6 mb-3">
        <label for="name" class="form-label">Name <span style="color: red">*</span></label>
        <input type="text" class="form-control" id="name" name="name" value="{{ ( isset($userDetail) ? $userDetail->name: old('name') )}}" required autocomplete="off" placeholder="Enter name">
    </div>

    <div class="col-lg-6 mb-3">
        <label for="email" class="form-label">Email <span style="color: red">*</span></label>
        <input type="email" class="form-control" id="email" name="email" value="{{ ( isset($userDetail) ? $userDetail->email: old('email') )}}" required autocomplete="off" placeholder="Enter email">
    </div>

    <div class="col-lg-6 mb-3">
        <label for="username" class="form-label">Username <span style="color: red">*</span></label>
        <input type="text" class="form-control" id="username" name="username" value="{{ ( isset($userDetail) ? $userDetail->username: old('username') )}}" required autocomplete="off" placeholder="Enter username">
    </div>

    @if(!isset($userDetail))
        <div class="col-lg-6 mb-3">
            <label for="password" class="form-label">Password <span style="color: red">*</span></label>
            <input type="password" class="form-control" id="password" name="password" value="" autocomplete="off" placeholder="Enter  password" required>
        </div>
    @endif

    <div class="col-lg-6 mb-3">
        <label for="role" class="form-label">Role <span style="color: red">*</span></label>
        <select class="form-select" id="role" name="role_id" required>
            <option value="" {{isset($userDetail) ? '': 'selected'}}  disabled>Select Role</option>
            @if($roles)
                @foreach($roles as $key =>  $value)
                    <option value="{{$value->id}}" {{ isset($userDetail) && ($userDetail->role_id ) == $value->id ? 'selected': old('role_id') }}>
                        {{ucfirst($value->name)}}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="address" class="form-label">Address <span style="color: red">*</span></label>
        <input type="text" class="form-control" id="address" required name="address" value=" {{ ( isset($userDetail) ? ($userDetail->address): old('address') )}}" autocomplete="off" placeholder="Enter Employee Address">
    </div>

    <div class="col-lg-6 mb-3">
        <label for="dob" class="form-label"> Date Of Birth <span style="color: red">*</span></label>
        <input type="date" class="form-control" id="dob" name="dob" value="{{ ( isset($userDetail) ? ($userDetail->dob): old('dob') )}}" required autocomplete="off" placeholder="">
    </div>

    <div class="col-lg-6 mb-3">
        <label for="number" class="form-label">Phone No <span style="color: red">*</span></label>
        <input type="number" class="form-control" id="phone" name="phone" value="{{ isset($userDetail)? $userDetail->phone: old('phone') }}" required autocomplete="off" placeholder="">
    </div>

    <div class="col-lg-6 mb-3">
        <label for="gender" class="form-label">Gender <span style="color: red">*</span></label>
        <select class="form-select" id="gender" name="gender" required >
            <option value="" {{isset($userDetail) ? '' : 'selected'}}  disabled>Select Gender</option>
            @foreach(\App\Models\User::GENDER as $value)
                <option value="{{$value}}" {{ isset($userDetail) && ($userDetail->gender ) == $value ? 'selected': '' }}>
                    {{ucfirst($value)}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="company_id" class="form-label">Company Name</label>
        <select class="form-select" id="company_id" name="company_id" required>
            <option selected value="{{ isset($companyDetail) ? $companyDetail->id : '' }}" >{{ isset($companyDetail) ? $companyDetail->name : ''}}</option>
        </select>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="branch_id" class="form-label">Branch <span style="color: red">*</span></label>
        <select class="form-select" id="branch" name="branch_id" required >
            <option value="" {{!isset($userDetail) ? 'selected': ''}}  disabled >Select Branch</option>
            @if(isset($companyDetail))
                @foreach($companyDetail->branches()->get() as $key => $branch)
                    <option value="{{$branch->id}}" {{ isset($userDetail) && ($userDetail->branch_id ) == $branch->id ? 'selected': old('is_active') }}>{{ucfirst($branch->name)}}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="department" class="form-label">Departments <span style="color: red">*</span></label>
        <select class="form-select" id="department" name="department_id" required>

        </select>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="post" class="form-label">Post <span style="color: red">*</span></label>
        <select class="form-select" id="post" name="post_id" required>

        </select>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="supervisor" class="form-label">Supervisor <span style="color: red">*</span></label>
        <select class="form-select" id="supervisor" name="supervisor_id">

        </select>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="officeTime" class="form-label">Office Time <span style="color: red">*</span></label>
        <select class="form-select" id="officeTime" name="office_time_id" required>

        </select>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="employment_type" class="form-label">Employment Type <span style="color: red">*</span> </label>
        <select class="form-select" id="employment_type" name="employment_type" required>
            <option value="" {{isset($userDetail) ? '': 'selected'}}  disabled>select employment type</option>
            @foreach(\App\Models\User::EMPLOYMENT_TYPE as $value)
                <option value="{{$value}}" {{ isset($userDetail) && ($userDetail->employment_type ) == $value ? 'selected': old('employment_type') }}>
                    {{ucfirst($value)}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="user_type" class="form-label">User Type <span style="color: red">*</span></label>
        <select class="form-select" id="user_type" name="user_type" required >
            <option value="" {{isset($userDetail) ? '': 'selected'}}  disabled>select user type</option>
            @foreach(\App\Models\User::USER_TYPE as $value)
                <option value="{{ $value }}" {{ isset($userDetail) && ($userDetail->user_type ) == $value ? 'selected': old('user_type') }}>
                    {{ucfirst($value)}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="joining_date" class="form-label"> Joining Date</label>
        <input type="date" class="form-control" id="joining_date" name="joining_date" value="{{ ( isset($userDetail) ? ($userDetail->joining_date): old('joining_date') )}}"  autocomplete="off" placeholder="Enter Joining Date">
    </div>

    <div class="col-lg-6 mb-3">
        <label for="workspace_type" class="form-label">WorkSpace</label>
        <select class="form-select" id="workspace_type" name="workspace_type" >
            <option value="" {{isset($userDetail) ? '': 'selected'}}  disabled>select work place </option>
            <option value="{{\App\Models\User::OFFICE}}" {{ isset($userDetail) && ($userDetail->workspace_type ) == \App\Models\User::OFFICE ? 'selected': old('workspace_type') }}>Office</option>
            <option value="{{\App\Models\User::HOME}}" {{ isset($userDetail) && ($userDetail->workspace_type ) == \App\Models\User::HOME ? 'selected': old('workspace_type') }}>Home</option>
        </select>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="bank_name" class="form-label">Bank Name <span style="color: red">*</span></label>
        <input type="text" class="form-control"   id="bank_name"  name="bank_name" value="{{ isset($userDetail) ? $userDetail->bank_name: old('bank_name') }}" autocomplete="off" placeholder="Enter Bank Name">
    </div>

    <div class="col-lg-6 mb-3">
        <label for="bank_account_no" class="form-label">Bank Account Number <span style="color: red">*</span></label>
        <input type="number" class="form-control"  id="bank_account_no"  name="bank_account_no" value="{{ isset($userDetail) ? $userDetail->bank_account_no: old('bank_account_no') }}" autocomplete="off" placeholder=" Enter Bank Account Number">
    </div>

    <div class="col-lg-6 mb-3">
        <label for="bank_account_type" class="form-label">Bank Account Type<span style="color: red">*</span></label>
        <select class="form-select" id="bank_account_type" name="bank_account_type" required>
            <option value="" {{isset($userDetail) ? '': 'selected'}}  >select account type</option>
            @foreach(\App\Models\User::BANK_ACCOUNT_TYPE as $value)
                <option value="{{ $value }}" {{ isset($userDetail) && ($userDetail->bank_account_type ) == $value ? 'selected': old('bank_account_type') }}>
                    {{ucfirst($value)}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="number" class="form-label">Leave Allocated</label>
        <input type="number" class="form-control" min="0"   id="leave_allocated"  name="leave_allocated" value="{{ isset($userDetail) ? $userDetail->leave_allocated: old('leave_allocated') }}" autocomplete="off" placeholder="">
    </div>

    <div class="col-lg-6 mb-3">
        <label for="number" class="form-label">Salary</label>
        <input type="number" class="form-control" min="0"  id="salary" name="salary" value="{{ isset($userDetail) ? $userDetail->salary: old('salary') }}" autocomplete="off" placeholder="Enter Salary">
    </div>

    <div class="col-lg-6 mb-3">
        <label for="status" class="form-label">Verification Status <span style="color: red">*</span></label>
        <select class="form-select" id="status" name="status" required >
            <option value="" {{isset($userDetail) ? '': 'selected'}}  disabled>select verification status</option>
            @foreach(\App\Models\User::STATUS as $value)
                <option value="{{$value}}" {{ isset($userDetail) && ($userDetail->status ) == $value ? 'selected': old('status') }}>
                    {{ucfirst($value)}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="is_active" class="form-label">User Status <span style="color: red">*</span></label>
        <select class="form-select" id="is_active" name="is_active" required>
            <option value="" {{isset($userDetail) ? '': 'selected'}}  disabled>select status </option>
            <option value="1" {{ isset($userDetail) && ($userDetail->is_active ) == 1 ? 'selected': old('is_active') }}>Active</option>
            <option value="0" {{ isset($userDetail) && ($userDetail->is_active ) == 0 ? 'selected': old('is_active') }}>Inactive</option>
        </select>
    </div>

    <div class="col-lg-12 mb-3">
        <label for="avatar" class="form-label">Upload Avatar <span style="color: red">*</span> </label>
        <input class="form-control" type="file" id="avatar" name="avatar" value="{{ isset($userDetail) ? $userDetail->avatar: old('avatar') }}" {{isset($userDetail) ? '': 'required'}} >
        @if(isset($userDetail) && $userDetail->avatar)
{{--            {{dd(asset(\App\Models\User::AVATAR_UPLOAD_PATH.$userDetail->avatar))}}--}}
        <img class="mt-3" src="{{asset(\App\Models\User::AVATAR_UPLOAD_PATH.$userDetail->avatar)}}"
              alt="" width="200" style="object-fit: contain"
              height="200">
        @endif
    </div>

    <div class="col-lg-12 mb-3">
        <label for="remarks" class="form-label">Description</label>
        <textarea class="form-control" name="remarks" id="tinymceExample" rows="2">{{ ( isset($userDetail) ? $userDetail->remarks: old('remarks') )}}</textarea>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> {{isset($userDetail)? 'Update':'Create'}} User</button>
    </div>
</div>



