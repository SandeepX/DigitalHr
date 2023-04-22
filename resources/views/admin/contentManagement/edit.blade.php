
@extends('layouts.master')

@section('title','Edit Content')

@section('action','Edit Static Page Content')

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.contentManagement.common.breadcrumb')

        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{route('admin.static-page-contents.update',$companyContentDetail->id)}}" enctype="multipart/form-data" method="post">
                    @method('PUT')
                    @csrf
                    @include('admin.contentManagement.common.form')
                </form>
            </div>
        </div>

    </section>
@endsection

@section('scripts')

    @include('admin.contentManagement.common.scripts')

@endsection

