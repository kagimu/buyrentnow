@extends('layouts.master')

@section('content')

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{session('title')}}</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <a class="btn btn-success" href="{{ route('create.partners') }}"> Create Partner</a>

    </div>
</div>
<!--End Page header-->

<!-- Row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">All Posts</div>
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
                                <th class="wd-15p border-bottom-0">partner's name</th>
                                <th class="wd-15p border-bottom-0">CATEGORY</th>
                                <th class="wd-15p border-bottom-0">Cover image</th>
                                <th class="wd-20p border-bottom-0">IMAGES</th>
                                <th class="wd-15p border-bottom-0">DATE</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($partners as $partner)
                            <tr>
                                <td>{{$partner->id}}</td>
                                <td>{{$partner->partner_name}}</td>
                                <td>{{$partner->partner_category}}</td>
                                <td>{{$partner->cover_pic}}</td>
                                <td>
                                    @foreach($partner->programs_supported_images ?? [] as $image)
                                    @if(is_string($image))
                                    <img src="{{ asset('storage/' . $image)  }}" alt="Image" width="10" height='10'>
                                    @endif
                                    @endforeach


                                </td>
                                <td>{{$partner->created_at}}</td>
                                <td>{{$partner->comments_count}}</td>
                                <td>
                                    <a href="{{route('edit.impacts', $partner->id)}}"
                                        class="btn btn-light mr-2">Edit</a>
                                    <a href="{{route('confirm_delete.impacts', $partner->id)}}"
                                        class="btn btn-light">Delete</a>
                                </td>
                                <td><a href="{{route('show.impacts', $partner->id)}}" class="btn btn-light">View
                                        Property</a>
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