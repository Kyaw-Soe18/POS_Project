@extends('admin.layouts.master')

@section('content')
     <!-- Begin Page Content -->
     <div class="container-fluid">

        <a href="{{ route('userOrderList')}}" class=" m-2"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
        <!-- DataTales Example -->

        <div class="row">
            <div class="card col-5 shadow-sm m-2 col">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5">Name: </div>
                        <div class="col-7"> {{ $order[0]->customer_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Phone: </div>
                        <div class="col-7"> {{ $order[0]->user_phone }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Code: </div>
                        <div class="col-7"> {{ $order[0]->order_code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Date: </div>
                        <div class="col-7"> {{ $order[0]->created_at->format('j-F-Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Total Price: </div>
                        <div class="col-7">
                            {{ $total + 3000 }} <br>
                            <small class="text-danger">( Contain Delivery Charges )</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card col-5 shadow-sm m-2 col">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5">Contact Phone: </div>
                        <div class="col-7"> {{ $payslipData->phone }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Payment method: </div>
                        <div class="col-7"> {{ $payslipData->payment_type }}</div>
                    </div>
                    <div class="row mb-3">
                        <img style="width: 150px" src="{{ asset('payslipRecords/'.$payslipData->payslip_image) }}" class="img-thumbnail">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="col-2">Image</th>
                                <th>Name</th>
                                <th>Count</th>
                                <th>Product Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($order as $item)
                            <tr>
                                <td><img src="{{asset('productImages/'.$item->product_image)}}" class=" img-thumbnail " alt=""></td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->order_count }}</td>
                                <td>{{ $item->product_price }}</td>
                                <td>{{ $item->order_count * $item->product_price }}</td>
                            </tr>
                           @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection