@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Account Information</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row col-10 offset-1">
                    <div class="col-3">  
                            @if (auth()->user()->profile == null)
                                <img class="img-thumbnail" id="output" src="{{ asset('admin/img/undraw_profile.svg') }}">
                            @else
                                 <img class="img-thumbnail" id="output" src="{{ asset('adminProfile/'.$account->profile) }}">
                            @endif
                            
                    </div>

                    <div class="col">
                        <div class="row mt-3">
                            <div class="col-3 h5">Name: </div>
                            <div class="col h5">{{ $account->name == null ? $account->nickname : $account->name }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3 h5">Email: </div>
                            <div class="col h5">{{ $account->email }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3 h5">Phone: </div>
                            <div class="col h5">{{ $account->phone == null ? '...' : $account->phone }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3 h5">Address: </div>
                            <div class="col h5">{{ $account->address == null ? '...' : $account->address }}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection