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
                            <form action="{{route('productList')}}" method="GET">
                                <div class="input-group mb-3">
                                        <input type="text" name="searchKey" class="form-control" placeholder="Products name..." value="{{ request('searchKey') }}" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                        </form>
                        </h6>
                    </div>
                    <div class="">
                        <a href="{{ route('productCreate')}}"><i class="fa-solid fa-plus"></i> Add Products</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="col-2">Name</th>
                                <th class="col-1">Image</th>
                                <th class="col-2">Price</th>
                                <th class="col-2">Stock</th>
                                <th class="col-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td><img src="{{asset('productImages/'.$item->image)}}" class=" img-thumbnail " alt=""></td>
                                <td>{{$item->price}} mmk</td>
                                <td>{{$item->count}}</td>
                                <td>
                                    <a href="{{ route('productDetails', $item->id)}}"><i class="fa-solid fa-eye btn btn-primary"></i></a>
                                    <a href="{{ route('productEdit', $item->id)}}"><i class="fa-solid fa-pen-to-square btn btn-secondary"></i></a>
                                    <a href=" {{ route('productDelete', $item->id)}}"><i class="fa-solid fa-trash-can btn btn-danger"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span class=" d-flex justify-content-end">{{$products->links()}}</span>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection