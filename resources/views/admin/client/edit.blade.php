
@extends('layouts.master')

@section('title','Edit Client ')

@section('action','Edit Client Detail')

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.client.common.breadcrumb')

        <div class="card">
            <div class="card-body">
                <form id="clientEdit" class="forms-sample" action="{{route('admin.clients.update',$clientDetail->id)}}" enctype="multipart/form-data"   method="post">
                    @method('PUT')
                    @csrf
                    @include('admin.client.common.form')
                </form>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
    @include('admin.client.common.scripts')
@endsection

