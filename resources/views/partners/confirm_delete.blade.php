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

        <div class="col-lg-12">
                 <div class="p-4 bg-light border border-bottom-0 mg-t-20">
                        <div class="modal d-block pos-static">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center p-4">
                                        <i class="fe fe-x-circle fs-100 text-danger lh-1 mb-4 d-inline-block"></i>
                                        <h4 class="text-danger mb-20">Delete Post</h4>
                                       <p class="mb-4 mx-4">Are you sure you would like to delete this Property entirely?</p>

                                       @if ($post)
                                            <form action="{{ route('deletePost.posts')}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{$post->id}}">
                                                <a href="{{ route('index.posts') }}" class="btn btn-primary pd-x-25">Cancel</a>
                                                <button class="btn btn-danger pd-x-25" type="submit">Yes, Delete</button>
                                            </form>
                                        @else
                                            <p>This post does not exist.</p>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
        </div>
    </div>

    <!-- End Row -->

@endsection