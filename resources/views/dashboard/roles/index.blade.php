@extends('layouts.dashboard')

@section('content')


    <div class="main-wrapper">

        <div class="page-wrapper">
            <div class="page-content">

                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">

            
                    <div class="container justify-content-center ">
                        <h2 style="font-size: 30px;" class="text-right-15 ">All roles</h2>
                    </div>

                    <div class="container pt-6 justify-content-center">

                         <div class="mb-5">
                             <a href="{{route('roles.create')}}" class="btn btn-primary m-9 ">Add role</a>
                        </div>

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
                               
                                <th scope="col">created_at</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($roles->count())
                                @foreach($roles as $role)
                                <tr>
                                <th scope="row">{{$role->id}}</th>
                                <td> <a href="{{route('roles.show',$role->id)}}">{{$role->name}}</a> </td>
                                <td>{{$role->created_at}}</td>
                                <td>
                                    <a href="{{route('roles.edit',$role->id)}}" class="btn btn-success">Edit</a>
                                    
                                </td>
                                <td>
                                    <form action="{{route('roles.destroy',$role->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4"> No roles Find</td>
                                </tr>
                                @endif
                                
                            </tbody>
                        </table>
                    </div>
                    

                </div>
                {{$roles->withQueryString()->links()}}
            </div>
        </div>
    </div>


@endsection