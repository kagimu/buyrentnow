@extends('layouts.master')

@section('content')

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{session('title')}}</h4>
    </div>
</div>
<!--End Page header-->


<div class="row">
    <div class="col-sm-12 col-md-6 col-xl-3">
        <div class="card bg-teal">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h6 class="text-white">Blog Posts</h6>
                        <h2 class="text-white m-0 font-weight-bold">{{$posts}}</h2>
                    </div>
                    <div class="ml-auto">
                        <span class="text-white display-6"><i class="fa fa-file-text-o fa-2x"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
        <div class="card bg-indigo">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h6 class="text-white">Users</h6>
                        <h2 class="text-white m-0 font-weight-bold">{{$clients}}</h2>
                    </div>
                    <div class="ml-auto">
                        <span class="text-white display-6"><i class="fa fa-users fa-2x"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
        <div class="card bg-teal">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h6 class="text-white">Impact Posts</h6>
                        <h2 class="text-white m-0 font-weight-bold">{{$impacts}}</h2>
                    </div>
                    <div class="ml-auto">
                        <span class="text-white display-6"><i class="fa fa-wrench fa-2x"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
        <div class="card bg-indigo">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h6 class="text-white">Partners</h6>
                        <h2 class="text-white m-0 font-weight-bold">15</h2>
                    </div>
                    <div class="ml-auto">
                        <span class="text-white display-6"><i class="fa fa-th-list fa-2x"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Most Active Staff</h3>
                <div class="card-options ">
                </div>
            </div>
            <div class="card-body">
                <div class="">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap mb-0 border">
                                <thead>
                                    <tr>
                                        <th class="wd-lg-10p">NAME</th>
                                        <th class="wd-lg-10p">Surname</th>
                                        <th class="wd-lg-10p">Posts Uploaded</th>
                                        <th class="wd-lg-10p">Impacts Uploaded</th>
                                        <th class="wd-lg-10p">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($active_clients as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>
                                            {{number_format($user->posts->count())}} posts
                                        </td>
                                        <td>
                                            {{number_format($user->impacts->count())}} impacts
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $user->online == 1 ? 'success' : 'danger' }} mt-2">
                                                {{ $user->online == 1 ? 'online' : 'offline' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection