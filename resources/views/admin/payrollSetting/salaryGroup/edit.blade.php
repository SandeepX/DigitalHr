@extends('layouts.master')

@section('title','Edit')

@section('page')
    <a href="{{ route('admin.salary-groups.index')}}">
        Salary Group
    </a>
@endsection

@section('sub_page','Edit')

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.payrollSetting.common.breadcrumb')

        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{route('admin.salary-groups.update',$salaryGroupDetail->id)}}"  method="POST">
                    @method('PUT')
                    @csrf
                    @include('admin.payrollSetting.salaryGroup.common.form')
                </form>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
    @include('admin.payrollSetting.salaryGroup.common.scripts')
@endsection
