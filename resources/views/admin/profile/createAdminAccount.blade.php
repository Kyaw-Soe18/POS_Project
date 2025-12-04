@extends('admin.layouts.master')

@section('content')
     <!-- Begin Page Content -->
     <div class="container-fluid">

                  
        <!-- DataTales Example -->
        <div class="card shadow mb-4 col-5">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Create Admin Account</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('createAdmin')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Account Name</label>
                        <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" id="exampleFormControlInput1" placeholder="Enter New Admin name...">
                        @error('name')
                            <small class=" invalid-feedback">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" id="exampleFormControlInput1" placeholder="Enter email...">
                        @error('email')
                            <small class=" invalid-feedback">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Password</label>
                        <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" value="{{old('password')}}" id="exampleFormControlInput1" placeholder="Enter password...">
                        @error('password')
                            <small class=" invalid-feedback">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control  @error('confirmPassword') is-invalid @enderror" name="confirmPassword" value="{{old('confirmPassword')}}" id="exampleFormControlInput1" placeholder="Confirm Password...">
                        @error('confirmPassword')
                            <small class=" invalid-feedback">{{$message}}</small>
                        @enderror
                    </div>

                    <input type="submit" value="Create" class="btn btn-primary">
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection