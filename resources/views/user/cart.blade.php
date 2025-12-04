@extends('user.layouts.master')

@section('content')
    <!-- Cart Page Start -->
    <div class="container-fluid" style="margin-top:150px;">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" name="" value="{{ auth()->user()->id }}" class="userId">

                        @foreach ($cart as $item)
                        <tr>
                            <input type="hidden" name="" value="{{ $item->product_id}}" class="productId">

                            <th scope="row">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('productImages/'.$item->image) }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;"
                                        alt="">
                                </div>
                            </th>
                            <td>
                                <p class="mb-0 mt-4">{{ $item->name}}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4 price" id="price">{{ $item->price}} mmk</p>
                            </td>
                            <td>
                                <div class="input-group quantity mt-4" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" id="qty" class="form-control qty form-control-sm text-center border-0"
                                        value="{{ $item->qty}}">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 mt-4 total" id="eachTotal">{{ $item->price * $item->qty}} mmk</p>
                            </td>
                            <td>
                                <input type="hidden" id="cartId" value="{{ $item->id }}">
                                <button class="btn btn-md rounded-circle bg-light border mt-4 btn-remove">
                                    <i class="fa fa-times text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row g-4 justify-content-end">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4">
                            <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Subtotal:</h5>
                                <p class="mb-0" id="subTotal">{{ $totalPrice }} mmk</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 me-4">Delivery </h5>
                                <div class="">
                                    <p class="mb-0"> 3000 mmk </p>
                                </div>
                            </div>
                        </div>
                        <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                            <h5 class="mb-0 ps-4 me-4">Total</h5>
                            <p class="mb-0 pe-4 " id="finalFee">{{ $totalPrice + 3000 }} mmk</p>
                        </div>

                        <button id="btn-checkout" @if(count($cart) == 0) disabled @endif
                            class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4"
                            type="button">Payment Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->
@endsection

@section('js-section')
<script>
    $(document).ready(function(){

        // when plus button clicked
        $('.btn-plus').click(function(){
            $parentNode = $(this).parents("tr");
            $price = Number( $parentNode.find('#price').text().replace("mmk", ""));
            $qty = Number( $parentNode.find('#qty').val())

            $totalPrice = $price*$qty;

            $parentNode.find("#eachTotal").html( $totalPrice + "mmk");
            finalCalculation()
        })

        // when minus button clicked
        $('.btn-minus').click(function(){
            $parentNode = $(this).parents("tr");
            $price = Number( $parentNode.find('#price').text().replace("mmk", ""));
            $qty = Number( $parentNode.find('#qty').val());

            $totalPrice = $price*$qty;

            $parentNode.find("#eachTotal").html( $totalPrice + "mmk");
            finalCalculation()
        })

        // when btn remove clicked
        $('.btn-remove').click(function(){
            $parentNode = $(this).parents("tr");
            $cartId = $parentNode.find('#cartId').val();

            // console.log($cartId);

            $deleteData = {
                'cartId' : $cartId
            }
            
            $.ajax({
                type : 'get',
                url : 'remove/cart',
                data : $deleteData,
                dataType : 'json',
                success : function(response){
                    if(response.message == 'success'){
                        location.reload();
                    }
                    
                }
            });
        })

        // user_id | product_id | order_code |    status

        $('#btn-checkout').click(function(){

            $orderList = []

            $orderCode = Math.floor(Math.random() * 10000000) // random value
            $userId = $('.userId').val() * 1;
            $totalPrice = $('#finalFee').text().replace("mmk", "") * 1;

            $( "#dataTable tbody tr" ).each(function( item, row){
                $productId = $(row).find('.productId').val() * 1;
                $qty = $(row).find('.qty').val() * 1;
                $totalPrice = $(row).find('#eachTotal').text().replace("mmk", "") * 1
                
                $orderList.push({
                    'user_id' : $userId,
                    'product_id' : $productId,
                    'order_code' : "Pos" + $orderCode,
                    'total_price' : $totalPrice,
                    'qty' : $qty
                 })
            })
            
            $.ajax({
                type : 'get',
                url : 'order',
                data : Object.assign({},$orderList),
                dataType : 'json',
                success : function(response){
                    if(response.message == "success"){
                        location.href = "payment"
                    }
                }
            })

        })

        function finalCalculation(){
            $totalPrice = 0;
            $( "#dataTable tbody tr" ).each(function( item, row){
                $totalPrice += Number( $(row).find("#eachTotal").text().replace("mmk", "") );
            })
            //console.log($totalPrice);

             $("#subTotal").html(`${$totalPrice} MMK `)
            $("#finalFee").html(`${$totalPrice+3000} MMK `)
        }
    })
</script>
@endsection