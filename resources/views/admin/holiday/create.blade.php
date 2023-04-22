
@extends('layouts.master')

@section('title','Holiday')

@section('action','Create')

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.holiday.common.breadcrumb')
        <div class="card">
            <div class="card-body">
                <h4 class="mb-4">Holiday</h4>
                <form class="forms-sample" action="{{route('admin.holidays.store')}}" method="POST">
                    @csrf
                    @include('admin.holiday.common.form')
                </form>
            </div>
        </div>

    </section>
@endsection

@section('scripts')

    @include('admin.holiday.common.scripts')

@endsection
