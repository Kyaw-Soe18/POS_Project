@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Admin Profile</h6>
                    </div>
                </div>
            </div>
            <form action="{{ route('profileUpdate') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <input type="hidden" name="oldImage" value="{{ auth()->user()->image}}">
                            
                            @if (auth()->user()->image == null)
                                <img class="img-thumbnail" id="output" src="{{ asset('admin/img/undraw_profile.svg') }}">
                            @else
                                 <img class="img-thumbnail" id="output" src="{{ asset('adminProfile/'.auth()->user()->image) }}">
                            @endif
                            
                            <input type="file" name="image" class=" form-control @error('image') is-invalid @enderror"
                                onchange="loadFile(event)" id="">
                            @error('image')
                                <small class=" invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col">

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Name</label>
                                        <input type="text" name="name" @if(auth()->user()->provider != 'simple') disabled @endif
                                            class="form-control @error('name') is-invalid @enderror"
                                            id="exampleFormControlInput1" placeholder="Enter Name..."
                                            value="{{ old('name', auth()->user()->name == null ? auth()->user()->nickname : auth()->user()->name) }}">
                                        @error('name')
                                            <small class=" invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                                        <input type="text" name="email" @if(auth()->user()->provider != 'simple') disabled @endif class="form-control @error('email') is-invalid @enderror"
                                            id="exampleFormControlInput1" placeholder="Enter Email..." value="{{old('email', auth()->user()->email)}}">
                                        @error('email')
                                            <small class=" invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                            id="exampleFormControlInput1" placeholder="09xxxxxx" value="{{old('phone', auth()->user()->phone)}}">
                                        @error('phone')
                                            <small class=" invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">address</label>
                                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                            id="exampleFormControlInput1" placeholder="Enter Address..." value="{{ old('address', auth()->user()->address)}}">
                                        @error('address')
                                            <small class=" invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @if (auth()->user()->provider == 'simple')
                                <a href="{{route('passwordChange')}}">Change Password</a>
                            @endif
                            <br><br>
                            <input type="submit" value="Update" class="btn btn-primary mt-2">
                        </div>
                    </div>
            </form>
        </div>
    </div>

    </div>
    <!-- /.container-fluid -->
@endsection