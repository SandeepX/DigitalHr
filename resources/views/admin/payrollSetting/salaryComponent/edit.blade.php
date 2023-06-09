
@extends('layouts.master')

@section('title','Edit')

@section('page')
    <a href="{{ route('admin.salary-components.index')}}">
        Salary components
    </a>
@endsection

@section('sub_page','Edit')

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.payrollSetting.common.breadcrumb')

        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{route('admin.salary-components.update',$salaryComponentDetail->id)}}"  method="POST">
                    @method('PUT')
                    @csrf
                    @include('admin.payrollSetting.salaryComponent.common.form')
                </form>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
    @include('admin.payrollSetting.salaryComponent.common.scripts')
@endsection
