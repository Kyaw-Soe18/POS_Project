@extends('user.layouts.master')

@section('content')
    <!-- Cart Page Start -->
    <div class="container-fluid py-5 mt-4" style="margin-top:150px;">
        <div class="row py-5 mt-4 ">
            <a href="{{ route('orderList')}}" class=" text-black m-3 "><i class="fa-solid fa-arrow-left"></i>Back</a>
        <!-- DataTales Example -->

        
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Order Board</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="col-1"> Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Count</th>
                                <th>Total Price</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order as $item)
                            <tr>
                             <td>
                                <img  src="{{asset('productImages/'.$item->product_image)}}" class=" img-thumbnail " alt="">
                             </td>
                             <td>{{$item->product_name}}</td>
                             <td>{{$item->product_price}}</td>
                             <td>{{$item->order_count}}</td>
                             <td>{{$item->order_count * $item->product_price}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        </div>

    </div>
    <!-- Cart Page End -->
@endsection