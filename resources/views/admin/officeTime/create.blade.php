
@extends('layouts.master')

@section('title','Create Office Time')

@section('action','Create')

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.officeTime.common.breadComb')
        <div class="card">
            <div class="card-body">
                <h4 class="mb-4">Office Schedule</h4>
                <form class="forms-sample" action="{{route('admin.office-times.store')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @include('admin.officeTime.common.form')
                </form>
            </div>
        </div>

    </section>
@endsection

@section('scripts')

    @include('admin.officeTime.common.scripts')
@endsection
