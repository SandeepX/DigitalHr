
@extends('layouts.master')

@section('title','Create Role')

@section('action','Create Role')

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.role.common.breadcrumb')

        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{route('admin.roles.store')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @include('admin.role.common.form')
                </form>
            </div>
        </div>

    </section>
@endsection
