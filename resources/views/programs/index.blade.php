@extends('layouts.master')

@section('content')

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{session('title')}}</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <a class="btn btn-success" href="{{ route('create.programs') }}"> Create Program</a>

    </div>
</div>
<!--End Page header-->

<!-- Row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">All Programs</div>
            </div>
            <div class="card-body">
                @if(Session::has('message'))
                <div class="alert alert-info" role="alert"><button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true"></button>
                    {{Session::get('message')}}
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="wd-15p border-bottom-0">TITLE</th>
                                <th class="wd-15p border-bottom-0">DESC</th>
                                <th class="wd-15p border-bottom-0">LOGO</th>
                                <th class="wd-15p border-bottom-0">PROFILE_IMAGE</th>
                                <th class="wd-20p border-bottom-0">IMAGES</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($programs as $program)
                            <tr>
                                <td>{{$program->id}}</td>
                                <td>{{$program->title}}</td>
                                <td>{{$program->desc}}</td>
                                <td><img src="{{ $program->logo_url }}" height="70"></td>
                                <td><img src="{{ $program->cover_pic_url }}" height="70"></td>
                                <td>
                                    @foreach($program->gallery_images ?? [] as $image)
                                    @if(is_string($image))
                                    <img src="{{ asset('storage/' . $image)  }}" alt="Image" width="10" height='10'>
                                    @endif
                                    @endforeach


                                </td>
                                <td>{{$program->created_at}}</td>
                                <td>
                                    <a href="{{route('edit.programs', $program->id)}}"
                                        class="btn btn-light mr-2">Edit</a>
                                    <a href="{{route('confirm_delete.programs', $program->id)}}"
                                        class="btn btn-light">Delete</a>
                                </td>
                                <td><a href="{{route('show.programs', $program->id)}}" class="btn btn-light">View
                                        Program</a>
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
    <!--End Page header-->

    @endsection