@extends('layouts.master')

@section('title','Assign Permission Setting')

@section('action','Permission Detail')

@section('button')
    <a href="{{route('admin.roles.index')}}" class="btn btn-primary btn-sm"> <i class="link-icon" data-feather="arrow-left"></i> Back </a>
@endsection

@section('main-content')
    <section class="content">
        @include('admin.section.flash_message')

        @include('admin.role.common.breadcrumb')

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Role:  {{ucfirst($role->name)}}</h3>
                <h3 class="card-title ">
                    List of Permissions:
                </h3>
            </div>
            <div class="card-body">
                <form class="forms-sample" action="{{route('admin.role.assign-permissions',$role->id)}}" method="post">
                    @method('PUT')
                    @csrf
                    @include('admin.role.common.permission')
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(function() {
                $('.js-check-all').on('click', function() {
                    let isChecked = $(this).parent().parent().parent().siblings().children('.item').children().find('.module_checkbox').prop('checked');
                    if (isChecked) {
                        $(this).parent().parent().parent().siblings().children('.item').children().find('.module_checkbox').prop('checked', false);
                    }else{
                        $(this).parent().parent().parent().siblings().children('.item').children().find('.module_checkbox').prop( "checked", true);
                    }
                });
            });

        });

    </script>
@endsection






