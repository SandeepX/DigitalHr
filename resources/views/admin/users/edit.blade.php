
@extends('layouts.master')

@section('title','Edit User Detail')

@section('action','Edit User')

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.users.common.breadComb')

        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{route('admin.users.update',$userDetail->id)}}" enctype="multipart/form-data" method="post">
                    @method('PUT')
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

