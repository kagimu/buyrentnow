@extends('layouts.master')

@section('content')

<!-- Page header -->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{ session('title') }}</h4>
    </div>
    <div class="page-header">

        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <a class="btn btn-success" href="{{ route('create.users') }}"> Add New Staff Personel</a>
        </div>
    </div>
    <!-- End Page header -->
</div>
<!-- End Page header -->

<!-- Row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">List of Registered {{ session('title') }}</div>
            </div>
            <div class="card-body">
                @if(Session::has('message'))
                <div class="alert alert-info" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('message') }}
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="wd-15p border-bottom-0">Full name</th>
                                <th class="wd-15p border-bottom-0">Login time</th>
                                <th class="wd-20p border-bottom-0">Last seen</th>
                                <th class="wd-25p border-bottom-0">Status</th>
                                <th class="wd-25p border-bottom-0">Accurate Location</th>
                                <th class="wd-10p border-bottom-0">Registered Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->last_login}}</td>
                                <td>{{ $user->last_activity }}</td>
                                <td>
                                    <span class="badge badge-{{ $user->online == 1 ? 'success' : 'danger' }} mt-2">
                                        {{ $user->online == 1 ? 'online' : 'offline' }}
                                    </span>
                                </td>
                                <td>

                                    City: {{ $user->cityName }}<br>
                                    Region: {{ $user->regionName }}<br>
                                    Country: {{ $user->countryName }}
                                </td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                <td>
                                    <a href="{{route('edit.users', $user->id)}}" class="btn btn-light mr-2">Edit</a>
                                    <a href="{{route('confirm_delete.users', $user->id)}}"
                                        class="btn btn-light">Delete</a>
                                </td>
                                <td><a href="{{route('show.users', $user->id)}}" class="btn btn-light">View Property</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- table-responsive -->
            </div>
        </div>
    </div>
    <!-- End Row -->
</div>
<!-- End Page header -->

@endsection