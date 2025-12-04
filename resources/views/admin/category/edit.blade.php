@extends('admin.layouts.master')

@section('content')
     <!-- Begin Page Content -->
     <div class="container-fluid">

                  
        <!-- DataTales Example -->
        <div class="card shadow mb-4 col-5">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Update Category Page</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('categoryUpdate')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Category Name</label>
                        <input type="hidden" name="categoryId" value="{{ $data->id }}">
                        <input type="text" class="form-control  @error('category') is-invalid @enderror" name="category" value="{{ old('category', $data->name) }}" id="exampleFormControlInput1" placeholder="Enter category name...">
                        @error('category')
                            <small class=" invalid-feedback">{{$message}}</small>
                        @enderror
                    </div>
                    <input type="submit" value="Update" class="btn btn-primary">
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection