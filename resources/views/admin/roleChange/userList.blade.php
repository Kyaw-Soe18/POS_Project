@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

                  
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <form action="{{route('adminList')}}" method="GET">
                                <div class="input-group mb-3">
                                        <input type="text" name="searchKey" class="form-control" placeholder="Admin name..." value="{{ request('searchKey') }}" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                        </form>
                        </h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex mb-3">
                    <a href="{{ route('adminList') }}" class="btn btn-primary mr-3">Admin List <span class="badge badge-light">{{ $adminCount }}</span></a>
                    <a href="{{ route('userList') }}" class="btn btn-primary">User List <span class="badge badge-light">{{ $data->total() }}</span></a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="col-2">Name</th>
                                <th class="col-2">Email</th>
                                <th class="col-1">Phone</th>
                                <th class="col-1">Address</th>
                                <th class="col-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>
                                    @if ($item->name != null)
                                        <a href="{{ route('accountProfile',$item->id) }}">{{ $item->name }}</a>
                                    @else
                                        <a href="{{ route('accountProfile',$item->id) }}">{{ $item->nickname }}</a>
                                    @endif
                                </td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->phone}}</td>
                                <td>{{$item->address}}</td>
                                <td>
                                    @if (auth()->user()->role == 'superadmin')
                                            <a href="{{ route('deleteUserAccount', $item->id) }}">
                                                <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                                            </a>
                                            <a href="{{ route('changeAdminRole', $item->id) }}">
                                                <button class="btn btn-sm btn-primary">Change to admin role <i class="fa-solid fa-arrow-up"></i></button>
                                            </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">{{ $data->links() }}</div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection