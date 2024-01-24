@extends('layouts.master')

@section('content')


<!-- End Row-->

<div class="col-lg-12">>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add Personel</h4>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('index.clients') }}"> Back</a>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <div class="card-body">
            <form action="{{ route('register.users') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="first_name" class="form-label">Surname:</label>
                    <input type="text" name="first_name" class="form-control" placeholder="">
                    @error('first_name')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="last_name" class="form-label">Other Name</label>
                    <input type="text" name="last_name" class="form-control" placeholder="">
                    @error('last_name')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" name="username" class="form-control" placeholder="">
                    @error('username')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="position" class="form-label">Role / Position of work:</label>
                    <input type="text" name="position" class="form-control" placeholder="">
                    @error('position')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email:</label>
                    <input type="text" name="email" class="form-control" placeholder="">
                    @error('email')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label"> Password:</label>
                    <input type="password" name="password" class="form-control" placeholder="******">
                    @error('password')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password:</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="******">
                </div>
                <div class="col-md-10">
                    <label for='profile_pic' class="form-label">Select Profile Picture:</label>
                    <input type="file" name="profile_pic" id="profile_pic" class="form-control" />
                    @error('profile_pic')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>


                <button type="submit" class="btn btn-primary mt-5 mb-0">Add Personell</button>

            </form>
        </div>
    </div>
</div>

<!-- End Row -->

@endsection