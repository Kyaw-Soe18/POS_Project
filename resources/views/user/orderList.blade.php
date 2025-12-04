@extends('user.layouts.master')

@section('content')
    <!-- Cart Page Start -->
    <div class="container-fluid" style="margin-top:150px;">
        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Shop</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('userDashboard') }}">Home</a></li>
                <li class="breadcrumb-item active text-white">Order List</li>
            </ol>
        </div>
        <!-- Single Page Header End -->
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th scope="col">Order Date</th>
                            <th scope="col">Order Code</th>
                            <th scope="col">Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order as $item)
                        <tr>
                            <td><p class="mb-0 mt-4">{{ $item->created_at->format('j-F-Y') }}</p></td>
                            <td><a href="{{ route('orderDetails', $item->order_code) }}">{{ $item->order_code }}</a></td>
                            <td>
                                <p class="mb-0 mt-4">
                                    @if($item->status == 0)
                                        <span class="text-warning">Pending</span>
                                    @elseif($item->status == 1)
                                        <span class="text-success">Accept</span>
                                    @elseif($item->status == 2)
                                        <span class="text-danger">Reject</span>
                                    @endif
                                </p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <!-- Cart Page End -->
@endsection

