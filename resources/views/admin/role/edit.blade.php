
@extends('layouts.master')

@section('title','Edit Role')

@section('action','Edit Role')

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.role.common.breadcrumb')

        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{route('admin.roles.update',$roleDetail->id)}}" enctype="multipart/form-data" method="post">
                    @method('PUT')
                    @csrf
                    @include('admin.role.common.form')
                </form>
            </div>
        </div>

    </section>
@endsection

