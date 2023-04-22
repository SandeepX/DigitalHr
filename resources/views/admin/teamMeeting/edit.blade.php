
@extends('layouts.master')

@section('title','Team Meeting')

@section('action','Edit')

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.teamMeeting.common.breadcrumb')

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form id="notification" class="forms-sample" action="{{route('admin.team-meetings.update',$teamMeetingDetail->id)}}" enctype="multipart/form-data"  method="post">
                            @method('PUT')
                            @csrf
                            @include('admin.teamMeeting.common.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('scripts')

    @include('admin.teamMeeting.common.scripts')

    <script>
        $('#meetingDate').nepaliDatePicker({
            language: "english",
            dateFormat: "MM/DD/YYYY",
            ndpYear: true,
            ndpMonth: true,
            ndpYearCount: 20,
            disableAfter: "2089-12-30",
        });
    </script>

@endsection

