
@extends('layouts.master')

@section('title','Edit Office Time')

@section('action','Edit Office Time')

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.officeTime.common.breadComb')

        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{route('admin.office-times.update',$officeTime->id)}}" enctype="multipart/form-data" method="post">
                    @method('PUT')
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

