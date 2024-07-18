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
                                <th scope="col">StoreName</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($users as $user)
                                    <tr>
                                    <th scope="row">{{$user->id}}</th>
                                    <td>{{$user->store->name ?? ''}}</td>
                                    <td>{{$user->name?? ''}}</td>
                                    <th>{{$user->phone_number}}</th>
                                    <th>{{$user->email}}</th>
                                    <th>{{$user->type}}</th>

                                    </tr>
                                @endforeach
                               
                                
                            </tbody>
                        </table>
                    </div>
                    

                </div>
            </div>
        </div>
    </div> 


@endsection