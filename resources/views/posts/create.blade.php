@extends('layouts.master')

@section('content')


<!-- End Row-->

<div class="col-lg-12">>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add Post</h4>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('index.posts') }}"> Back</a>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <div class="card-body">
            <form action="{{ route('store.posts') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Title:</label>
                    <input type="text" name="name" class="form-control" placeholder="Name of the Property">
                    @error('name')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="desc" class="form-label">Description:</label>
                    <textarea name="desc" rows="4" cols="30" class="form-control tinymce-editor" required></textarea>
                    @error('desc')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="tag" class="form-label">tag:</label>
                    <input type="text" name="tag" class="form-control" placeholder="#">
                    @error('tag')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="location" class="form-label">Exact Location incase of event:</label>
                    <input type="text" name="location" class="form-control" placeholder="Location of the Property">
                    @error('location')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="owner" class="form-label">Author:</label>
                    <input type="text" name="owner" class="form-control" placeholder="">
                    @error('owner')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-10">
                    <label for="images" class="form-label">Upload Images of the Post:</label>
                    <input type="file" name="images[]" id="images" multiple="multiple" class="form-control">
                    @error('image')
                    <div class="alert alert-danger mt-4 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-10">
                    <label for='profile_pic' class="form-label">Select Cover Picture:</label>
                    <input type="file" name="profile_pic" id="profile_pic" class="form-control" />
                    @error('profile_pic')
                    <div class="alert alert-danger mt-4 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-10">
                    <label for='video' class="form-label">Select Video:</label>
                    <input type="file" name="video" id="video" class="form-control" />
                    @error('video')
                    <div class="alert alert-danger mt-4 mb-0">{{ $message }}</div>
                    @enderror
                </div>


                <button type="submit" class="btn btn-primary mt-5 mb-0">Create Blog</button>

            </form>
        </div>
    </div>
</div>

<!-- End Row -->

@endsection