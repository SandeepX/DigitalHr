
@extends('layouts.master')

@section('title','Tada')

@section('action','Edit Tada')

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/imageuploadify.min.css')}}">
@endsection

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.tada.common.breadcrumb')

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form id="editForm" class="forms-sample" action="{{route('admin.tadas.update',$tadaDetail->id)}}" enctype="multipart/form-data" method="POST">
                            @method('PUT')
                            @csrf
                            @include('admin.tada.common.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
    @include('admin.tada.common.scripts')
@endsection
