@extends('layouts.master')
@section('title','Salary Components')
@section('sub_page','Lists')
@section('page')
        <a href="{{ route('admin.salary-components.index')}}">
               Salary components
        </a>
@endsection

@section('main-content')
    <section class="content">
        @include('admin.section.flash_message')

        @include('admin.payrollSetting.common.breadcrumb')

        <div class="card">
            <div class="card-header">
                <div class="justify-content-end">
                    <a class="btn btn-success"
                       href="{{ route('admin.salary-components.create')}}">
                        <i class="link-icon" data-feather="plus"></i> Add Salary Component
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Component Type</th>
                                <th>Component Value</th>
                                <th>Value Type</th>
                                <th>Status</th>
                               <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                        @forelse($salaryComponentLists as $key => $value)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{ucfirst($value->name)}}</td>
                                <td>
                                    <span class="btn btn-info btn-xs"> {{(\App\Models\SalaryComponent::COMPONENT_TYPE[$value->component_type])}}</span>
                                </td>
                                <td>
                                    {{(\App\Models\SalaryComponent::VALUE_TYPE[$value->value_type])}}
                                </td>
                                <td>{{ $value->component_value_monthly  }}{{$value->value_type == 'fixed' ? '': '%'}}</td>
                                <td>
                                    <label class="switch">
                                        <input class="toggleStatus" href="{{route('admin.salary-components.toggle-status',$value->id)}}"
                                               type="checkbox" {{($value->status) == 1 ?'checked':''}}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td>
                                    <ul class="d-flex list-unstyled mb-0">
                                        <li class="me-2">
                                            <a href="{{route('admin.salary-components.edit',$value->id)}}" title="Edit Detail">
                                                <i class="link-icon" data-feather="edit"></i>
                                            </a>
                                        </li>

                                        <li>
                                            <a class="delete"
                                               data-href="{{route('admin.salary-components.delete',$value->id)}}" title="Delete">
                                                <i class="link-icon"  data-feather="delete"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">
                                    <p class="text-center"><b>No records found!</b></p>
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
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

            $('.toggleStatus').change(function (event) {
                event.preventDefault();
                var status = $(this).prop('checked') === true ? 1 : 0;
                var href = $(this).attr('href');
                Swal.fire({
                    title: 'Are you sure you want to change status ?',
                    showDenyButton: true,
                    confirmButtonText: `Yes`,
                    denyButtonText: `No`,
                    padding:'10px 50px 10px 50px',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }else if (result.isDenied) {
                        (status === 0)? $(this).prop('checked', true) :  $(this).prop('checked', false)
                    }
                })
            })

            $('.delete').click(function (event) {
                event.preventDefault();
                let href = $(this).data('href');
                Swal.fire({
                    title: 'Are you sure you want to Delete ?',
                    showDenyButton: true,
                    confirmButtonText: `Yes`,
                    denyButtonText: `No`,
                    padding:'10px 50px 10px 50px',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                })
            })
        });
    </script>
@endsection






