
@extends('layouts.master')

@section('title','Create Notice')

@section('action','Create')

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.notice.common.breadcrumb')

        <div class="card">
            <div class="card-body">
                <form id="notification" class="forms-sample" action="{{route('admin.notices.store')}}"  method="POST">
                    @csrf
                    @include('admin.notice.common.form')
                </form>
            </div>
        </div>

    </section>
@endsection

@section('scripts')


    @include('admin.notice.common.scripts')

@endsection
