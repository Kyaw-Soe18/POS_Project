@extends('user.layouts.master')

@section('content')
    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords"
                            aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Shop</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('userDashboard') }}">Home</a></li>
            <li class="breadcrumb-item active text-white">Shop</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <h1 class="mb-4">Trend Foods</h1>
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <div class="col-xl-3">
                            <form action="{{ route('shopList') }}" method="GET">
                                @csrf
                                <div class="input-group w-100 mx-auto d-flex">
                                    <input type="search" name="searchKey" value="{{ request('searchKey') }}"
                                        class="form-control p-3" placeholder="Search...">
                                    <button type="submit" class="input-group-text p-3">
                                        <i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-6"></div>
                    </div>
                    <div class="row g-4 mt-2">
                        <div class="col-lg-3">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4>Categories</h4>
                                        <ul class="list-unstyled fruite-categorie">
                                            <li>
                                                <div class="d-flex justify-content-between fruite-name">
                                                    <a href="{{ route('shopList') }}">
                                                    <i class="fas fa-apple-alt me-2"></i>All Categories</a>
                                                </div>
                                            </li>
                                            @foreach ($categories as $item)
                                                <li>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a href="{{ route('shopList', $item->id) }}">
                                                        <i class="fas fa-apple-alt me-2"></i>{{ $item->name }}</a>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <form action="{{ route('shopList') }}" method="GET">
                                        @csrf
                                        <input type="text" name="minPrice" value="{{ request('minPrice') }}" class="form-control my-2" placeholder="Minimum Price">
                                        <input type="text" name="maxPrice" value="{{ request('maxPrice') }}" class="form-control" placeholder="Maximum Price">
                                        <input type="submit" class="btn btn-secondary my-2" value="Filter">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-4 justify-content-center">
                                @foreach ($products as $item)
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <a href="{{ route('shopDetails', $item->id) }}">
                                                    <img style="height: 250px"
                                                        src="{{ asset('productImages/' . $item->image) }}"
                                                        class="img-fluid w-100 rounded-top" alt="">
                                                </a>
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">{{ $item->category_name }}</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>{{ $item->name }}</h4>
                                                <p>{{ Str::words($item->description, 10, '...') }}</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-2">
                                                        <i class="fa-solid fa-money-bill"></i> {{ $item->price }} MMK</p>
                                                    <a href="{{ route('shopDetails', $item->id) }}"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <i class="fa fa-shopping-bag me-2 text-primary"></i> See Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div>
                                    <div>
                                        <span class=" d-flex justify-content-end">{{ $products->links() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->
@endsection
