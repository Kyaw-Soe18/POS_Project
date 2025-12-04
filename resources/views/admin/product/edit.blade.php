@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Product Edit Page</h6>
                    </div>
                </div>
            </div>
            <form action="{{ route('productUpdate') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <input type="hidden" name="oldImage" value="{{ $products->image }}">
                            <input type="hidden" name="productId" value="{{ $products->id }}">
                            <img class="img-thumbnail" id="output" src="{{ asset('productImages/'.$products->image) }}" alt="">

                            <input type="file" name="image" class=" form-control @error('image') is-invalid @enderror"
                                onchange="loadFile(event)" id="">
                            @error('image')
                                <small class=" invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col">

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label"> Name</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            id="exampleFormControlInput1" placeholder="Enter product name..." value="{{old('name', $products->name)}}">
                                        @error('name')
                                            <small class=" invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Price (MMK)</label>
                                        <input type="text" name="price"
                                            class="form-control @error('price') is-invalid @enderror"
                                            id="exampleFormControlInput1" placeholder="Enter product price..." value="{{old('price', $products->price)}}">
                                        @error('price')
                                            <small class=" invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Category Name</label>
                                        <select name="categoryName" id=""
                                            class="form-control @error('categoryName') is-invalid @enderror">
                                            <option value="">Choose Category Name...</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}" @if(old('categoryName', $products->category_id) == $item->id) selected @endif >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('categoryName')
                                            <small class=" invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Count</label>
                                        <input type="text" name="count"
                                            class="form-control @error('count') is-invalid @enderror"
                                            id="exampleFormControlInput1" placeholder="Enter product count..." value="{{old('count', $products->count)}}">
                                        @error('count')
                                            <small class=" invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="exampleFormControlInput1" class="form-label ">Description</label>
                                    <textarea name="description" id="" class=" form-control @error('description') is-invalid @enderror"
                                        cols="30" rows="10" placeholder="Enter product description...">{{old('description', $products->description)}}</textarea>
                                    @error('description')
                                        <small class=" invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <input type="submit" value="Update" class="btn btn-primary mt-2">
                        </div>
                    </div>
            </form>
        </div>
    </div>

    </div>
    <!-- /.container-fluid -->
@endsection