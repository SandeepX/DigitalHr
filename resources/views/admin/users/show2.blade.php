
@extends('layouts.master')

@section('title','Show User Details')

@section('action','Show Detail')

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')
        @include('admin.users.common.breadComb')
        @can('edit_employee')
            <a style="float: right;" href="{{ route('admin.users.edit',$userDetail->id)}}">
                <button class="btn btn-primary">
                    <i class="link-icon" data-feather="edit"></i>Edit Detail
                </button>
            </a>
        @endcan

        <div class="d-flex align-items-center mb-2">
            <img class="wd-100 ht-100 rounded-circle" style="object-fit: cover" src="{{asset(\App\Models\User::AVATAR_UPLOAD_PATH.$userDetail->avatar)}}" alt="profile">
            <div class="text-start ms-3">
                <span class="fw-bold">{{ucfirst($userDetail->name)}}</span>
                <p class="">{{ucfirst($userDetail->email)}}</p>
            </div>
        </div>

        <div class="row profile-body">
            <div class="col-lg-4">
                <div class="card rounded">
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="card-title mb-0" style="align-content: center;">User Detail</h6>
                        </div>

                        <div class="mt-3">
                            <label class="fw-bolder mb-0 text-uppercase">Username:</label>
                            <p>{{($userDetail->username)}}</p>
                        </div>

                        <div class="mt-3">
                            <label class="fw-bolder mb-0 text-uppercase">Gender:</label>
                            <p>{{ucfirst($userDetail->gender)}}</p>
                        </div>

                        <div class="mt-3">
                            <label class="fw-bolder mb-0 text-uppercase">Address.:</label>
                            <p>{{ucfirst($userDetail->address)}}</p>
                        </div>

                        <div class="mt-3">
                            <label class="fw-bolder mb-0 text-uppercase">Phone No:</label>
                            <p>{{($userDetail->phone)}}</p>
                        </div>

                        <div class="mt-3">
                            <label class="fw-bolder mb-0 text-uppercase">Date Of Birth:</label>
                            <p> {{ \App\Helpers\AppHelper::formatDateForView($userDetail->dob) }}</p>
                        </div>

                        <div class="mt-3">
                            <label class="fw-bolder mb-0 text-uppercase">Role:</label>
                            <p>{{$userDetail->role ? ucfirst($userDetail->role->name):'N/A'}}</p>
                        </div>

                        <div class="mt-3">
                            <label class="fw-bolder mb-0 text-uppercase">Is Active:</label>
                            <p>{{($userDetail->is_active == 1) ? 'Yes':'No'}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                    <div class="card rounded">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="card-title mb-0" style="align-content: center;">Office Detail</h6>
                            </div>

                             <div class="mt-3">
                                <label class="fw-bolder mb-0 text-uppercase">Branch Name:</label>
                                <p>{{($userDetail->branch ? ucfirst($userDetail->branch->name) : 'N/A')}}</p>
                            </div>

                            <div class="mt-3">
                                <label class="fw-bolder mb-0 text-uppercase">Department Name:</label>
                                <p>{{$userDetail->department ? ucfirst($userDetail->department->dept_name) :'N/A'}}</p>
                            </div>

                            <div class="mt-3">
                                <label class="fw-bolder mb-0 text-uppercase">Post Name.:</label>
                                <p><p>{{ $userDetail->post ? ucfirst($userDetail->post->post_name) : 'N/A'}} </p>
                            </div>

                            <div class="mt-3">
                                <label class="fw-bolder mb-0 text-uppercase">Employment Type:</label>
                                <p>{{ucfirst($userDetail->employment_type)}}</p>
                            </div>

                            <div class="mt-3">
                                <label class="fw-bolder mb-0 text-uppercase">Joining Date:</label>
                                <p>{{\App\Helpers\AppHelper::formatDateForView($userDetail->joining_date)}}</p>
                            </div>

                            <div class="mt-3">
                                <label class="fw-bolder mb-0 text-uppercase">User Type:</label>
                                <p>{{ucfirst($userDetail->user_type)}}</p>
                            </div>

                            <div class="mt-3">
                                <label class="fw-bolder mb-0 text-uppercase">Workspace:</label>
                                <p>{{ ($userDetail->workspace_type == 1) ? 'Office' : 'Home'}}</p>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="col-md-4">
                <div class="card rounded">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="card-title mb-0" style="align-content: center;">Bank Detail</h6>
                        </div>

                        <div class="mt-3">
                            <label class="fw-bolder mb-0 text-uppercase">Bank Name:</label>
                            <p>{{ucfirst($userDetail->bank_name)}}</p>
                        </div>

                        <div class="mt-3">
                            <label class="fw-bolder mb-0 text-uppercase">Bank Account Number:</label>
                            <p>{{($userDetail->bank_account_no)}}</p>
                        </div>

                        <div class="mt-3">
                            <label class="fw-bolder mb-0 text-uppercase">Bank Account Type:</label>
                            <p>{{ucfirst($userDetail->bank_account_type)}}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>



    </section>
@endsection


