
@extends('layouts.master')

@section('title','Create Employee')

@section('action','Create Employee')

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.users.common.breadComb')

        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{route('admin.users.store')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @include('admin.users.common.form')
                </form>
            </div>
        </div>

    </section>
@endsection

@section('scripts')

@include('admin.users.common.scripts')

@endsection
