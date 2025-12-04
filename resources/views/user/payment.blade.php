@extends('user.layouts.master')

@section('content')
    <!-- Cart Page Start -->
    <div class="container-fluid" style="margin-top:150px;">
        
        <div class="container py-5">
            <div class="row">
                <div class="card col-10 offset-1 shadow-sm">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-4">
                                <h5 class="mb-4">Payment Account Info</h5>

                                @foreach ($payment as $item)
                                    {{ $item->type}} ( name : {{ $item->account_name }}) <br>
                                    Account - {{ $item->account_number }}
                                    <hr>
                                @endforeach
                            </div>
                            <div class="col-8">
                                <div class="container">
                                    <form action="{{ route('orderProduct') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-25">
                                                <label for="fname">နာမည်</label>
                                            </div>
                                            <div class="col-75">
                                                <input type="text" class="payment-form" id="fname" name="name" placeholder="Your name..">
                                                <br>
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-25">
                                                <label for="lname">ဖုန်း</label>
                                            </div>
                                            <div class="col-75">
                                                <input type="text" class="payment-form" id="lname" name="phone" placeholder="Your phone number..">
                                                <br>
                                                @error('phone')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-25">
                                                <label for="country">ငွေပေးချေမှုအမျိုးအစား</label>
                                            </div>
                                            <div class="col-75">
                                                <select id="country" class="payment-form" name="paymentMethod">
                                                    <option value="">Choose Payment Method</option>
                                                    @foreach ($payment as $item)
                                                        <option value="{{ $item->id }}">{{ $item->type }}</option>
                                                    @endforeach
                                                </select>
                                                <br>
                                                @error('paymentMethod')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-25">
                                                <label for="fname">ငွေပေးချေမှုစာရွက်</label>
                                            </div>
                                            <div class="col-75">
                                                <input type="file" class="payment-form" id="fname" name="payslipImage" placeholder="Your name..">
                                                <br>
                                                @error('payslipImage')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-25">
                                                <label for="fname">Order Code</label>
                                            </div>
                                            <div class="col-75">
                                                <input type="hidden" name="orderCode" value="{{$orderProduct[0]['order_code'] }}">
                                                <label for="">{{ $orderProduct[0]['order_code'] }}</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-25">
                                                <label for="fname">Total Amount</label>
                                            </div>
                                            <div class="col-75">
                                                <input type="hidden" name="totalAmount" value="{{ $total + 3000 }}">
                                                <label for="">{{ $total + 3000 }} mmk</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <input type="submit" value="Order Products">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->
@endsection

