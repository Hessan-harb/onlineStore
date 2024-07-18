@extends('layouts.dashboard')

@section('content')


    <div class="main-wrapper">

        <div class="page-wrapper">
            <div class="page-content">

                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">

            
                    <div class="container justify-content-center ">
                        <h2 style="font-size: 30px;" class="text-right-15 ">All Products</h2>
                    </div>

                    <div class="container pt-6 justify-content-center">

                         <div class="mb-5">
                             <a href="{{route('products.create')}}" class="btn btn-primary m-9 ">Add Product</a>
                        </div>

                       {{-- <div class="mb-5">
                             <a href="{{route('products.trash')}}" class="btn btn-primary m-9 ">Trash Product</a>
                        </div>--}}

                        <x-alert type="success" />

                        <form action="{{URL::current()}}" method="get" class="pb-3">
                            <x-form.input name="name" />
                            
                            <button class="btn btn-danger">Filter</button>
                        </form>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th scope="col">id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Store</th>
                                <th scope="col">created_at</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($products->count())
                                @foreach($products as $product)
                                <tr>
                                <th scope="row">{{$product->id}}</th>
                                <td>{{$product->name}}</td>
                                <td>{{$product->category->name ?? ''}}</td>
                                <td>{{$product->store->name}}</td>

                                <td>{{$product->created_at}}</td>
                                <td><img src="{{asset('storage/' . $product->image)}}" alt=""></td>
                                <td>
                                    <a href="{{route('products.edit',$product->id)}}" class="btn btn-success">Edit</a>
                                </td>
                                <td>
                                    <form action="{{route('products.destroy',$product->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="7"> No Products Find</td>
                                </tr>
                                @endif
                                
                            </tbody>
                        </table>
                    </div>
                    

                </div>
                {{$products->withQueryString()->links()}}
            </div>
        </div>
    </div>


@endsection