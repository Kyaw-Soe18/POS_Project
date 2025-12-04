@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Product Details Page</h6>
                    </div>
                </div>
            </div>
            <form action="{{ route('productCreate') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <img class=" img-thumbnail mt-1" id="output" src="{{ asset('productImages/'.$data->image) }}" alt="">
                        </div>

                        <div class="col">

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label"> Name</label>
                                        <h4>{{ $data->name }}</h4>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Price (MMK)</label>
                                        <h4>{{ $data->price }}</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Category Name</label>
                                        <h4>{{ $data->category_name}}</h4>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Stock Count</label>
                                        <h4>{{ $data->count }}</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="exampleFormControlInput1" class="form-label ">Description</label>
                                    <h4>{{ $data->description }}</h4>
                                </div>
                            </div>

                            <a href="{{ route('productList')}}"><input type="button" value="Back" class="btn btn-dark text-white mt-2"></a>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    </div>
    <!-- /.container-fluid -->
@endsection