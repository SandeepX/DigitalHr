@extends('layouts.master')
@section('title','Post')

@section('main-content')

    <section class="content">
        @include('admin.section.flash_message')

        <nav class="page-breadcrumb d-flex align-items-center justify-content-between">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.posts.index')}}">Post section</a></li>
                <li class="breadcrumb-item active" aria-current="page">Posts</li>
            </ol>

            @can('create_post')
                <a href="{{ route('admin.posts.create')}}">
                    <button class="btn btn-primary add_department">
                        <i class="link-icon" data-feather="plus"></i>Add Post
                    </button>
                </a>
            @endcan
        </nav>

        <div class="search-box p-4 bg-white rounded mb-3 box-shadow">
            <form class="forms-sample" action="{{route('admin.posts.index')}}" method="get">
                <div class="row align-items-center">

                    <div class="col-lg-2">
                        <h5>Posts Lists</h5>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <input type="text" placeholder="Search by Post name" name="name" value="" class="form-control">
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <select class="form-select form-select-lg" name="per_page">
                            <option value="" selected>Show Entries</option>
                            <option value="1">10</option>
                            <option value="2">20</option>
                            <option value="3">30</option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-4">
                        <button type="submit" class="btn btn-block btn-primary form-control">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Post Name</th>
                            <th>Department </th>
                            <th>Status</th>

                            @canany(['edit_post','delete_post'])
                                <th>Action</th>
                            @endcanany
                        </tr>
                        </thead>
                        <tbody>
                        <tr>

                        @forelse($posts as $key => $value)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{ucfirst($value->post_name)}}</td>
                                <td>{{ucfirst($value->department->dept_name)}}</td>

                                <td>
                                    <label class="switch">
                                        <input class="toggleStatus" href="{{route('admin.posts.toggle-status',$value->id)}}"
                                               type="checkbox" {{($value->is_active) == 1 ?'checked':''}}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                @canany(['edit_post','delete_post'])
                                    <td>
                                    <ul class="d-flex list-unstyled mb-0">

                                        @can('edit_post')
                                            <li class="me-2">
                                                <a href="{{route('admin.posts.edit',$value->id)}}">
                                                    <i class="link-icon" data-feather="edit"></i>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('delete_post')
                                            <li>
                                                <a class="deletePost"
                                                   data-href="{{route('admin.posts.delete',$value->id)}}">
                                                    <i class="link-icon"  data-feather="delete"></i>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </td>
                                @endcanany
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

        <div class="dataTables_paginate">
            {{$posts->appends($_GET)->links()}}
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
                    // width:'500px',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }else if (result.isDenied) {
                        (status === 0)? $(this).prop('checked', true) :  $(this).prop('checked', false)
                    }
                })
            })

            $('.deletePost').click(function (event) {
                event.preventDefault();
                let href = $(this).data('href');
                Swal.fire({
                    title: 'Are you sure you want to Delete Post ?',
                    showDenyButton: true,
                    confirmButtonText: `Yes`,
                    denyButtonText: `No`,
                    padding:'10px 50px 10px 50px',
                    // width:'1000px',
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






