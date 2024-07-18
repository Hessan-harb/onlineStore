@extends('layouts.dashboard')

@section('content')


    <div class="main-wrapper">

        <div class="page-wrapper">
            <div class="page-content">

                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">

            
                    <div class="container justify-content-center ">
                        <h2 style="font-size: 30px;" class="text-right-15 ">Trashed Categories</h2>
                    </div>

                    <div class="container pt-6 justify-content-center">

                         <div class="mb-5">
                             <a href="{{route('categories.index')}}" class="btn btn-primary m-9 ">Back</a>
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
                                <th scope="col">deleted_at</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($categories->count())
                                @foreach($categories as $category)
                                <tr>
                                <th scope="row">{{$category->id}}</th>
                                <td>{{$category->name}}</td>
                                <td>{{$category->deleted_at}}</td>
                                <td><img src="{{asset('storage/' . $category->image)}}" alt=""></td>
                                <td>
                                <form action="{{route('categories.restore',$category->id)}}" method="post">
                                        @csrf
                                        @method('put')
                                        <button class="btn btn-danger" type="submit">Restore</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{route('categories.forcedelete',$category->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger" type="submit">ForceDelete</button>
                                    </form>
                                </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="7"> No Categories Find</td>
                                </tr>
                                @endif
                                
                            </tbody>
                        </table>
                    </div>
                    

                </div>
                {{$categories->withQueryString()->links()}}
            </div>
        </div>
    </div>


@endsection