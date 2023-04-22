
@extends('layouts.master')

@section('title','Create Department')

{{--@section('nav-head','Company')--}}

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        <nav class="page-breadcrumb d-flex align-items-center justify-content-between">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.departments.index')}}">Department section</a></li>
                <li class="breadcrumb-item active" aria-current="page">Department create</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{route('admin.departments.store')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @include('admin.department.common.form')
                </form>
            </div>
        </div>

    </section>
@endsection

