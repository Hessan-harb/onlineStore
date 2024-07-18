@extends('layouts.dashboard')

@section('content')


    <div class="main-wrapper">

        <div class="page-wrapper">
            <div class="page-content">

                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">

            
                    <div class="container justify-content-center ">
                        <h2 style="font-size: 30px;" class="text-right-15 ">{{$category->name}}</h2>
                    </div>

                    <div class="container pt-6 justify-content-center">

                         <div class="mb-5">
                             <a href="{{route('categories.index')}}" class="btn btn-primary m-9 ">Back</a>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th scope="col">id</th>
                                <th scope="col">Name</th>
                                <th scope="col">parent</th>
                                <th scope="col">created_at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $products=$category->products()->with('store')->paginate(5); 
                                @endphp
                                @forelse($products as $product)
                                <tr>
                                    <th scope="row">{{$product->id}}</th>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->store->name}}</td>
                                    <td>{{$product->created_at}}</td>
                                    <td><img src="{{asset('storage/' . $product->image)}}" alt=""></td>
                                </tr>
                                @empty
                                <tr>
                                    <td>No Products defined</td>
                                </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                        {{$products->links()}}
                    </div>
                    

                </div>
            </div>
        </div>
    </div>


@endsection