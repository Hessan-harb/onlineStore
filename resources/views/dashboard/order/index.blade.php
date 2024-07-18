@extends('layouts.dashboard')

@section('content')


   <div class="main-wrapper">

        <div class="page-wrapper">
            <div class="page-content">

                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">

            
                    <div class="container justify-content-center ">
                        <h2 style="font-size: 30px;" class="text-right-15 ">All Orders</h2>
                    </div>

                    <div class="container pt-6 justify-content-center">

                    <x-alert type="success" />
                       
                        

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th scope="col">id</th>
                                <th scope="col">StoreId</th>
                                <th scope="col">User</th>
                                <th scope="col">Number</th>
                                <th scope="col">Status</th>
                                <th scope="col">pyment method</th>
                                <th scope="col">pyment status</th>
                                <th scope="col">created_at</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($orders as $order)
                                    <tr>
                                    <th scope="row">{{$order->id}}</th>
                                    <td>{{$order->store->name}}</td>
                                    <td>{{$order->user->name?? ''}}</td>
                                    <th>{{$order->number}}</th>
                                    <th>{{$order->status}}</th>
                                    <th>{{$order->payment_method}}</th>
                                    <th>{{$order->payment_status}}</th>
                                    <td>{{$order->created_at}}</td>
                                    
                                    <td>
                                        <form action="{{ route( 'orders.destroy',$order->id ) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                    </tr>
                                @endforeach
                               
                                
                            </tbody>
                        </table>
                    </div>
                    

                </div>
                {{$orders->withQueryString()->links()}}
            </div>
        </div>
    </div> 


@endsection