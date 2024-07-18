@extends('layouts.dashboard')

@section('content')
<div class="main-wrapper">

<div class="page-wrapper">
        <div class="page-content">

            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                
                
                <div class="container justify-content-center ">
                    <h2 style="font-size: 30px;" class="text-right-15 ">Edit role</h2>
                </div>
                <div class="container pt-6 justify-content-center">

                <div>
                    <form action="{{route('roles.update',$role->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        @include('dashboard.roles._form')
                    </form>
                </div>
            </div>
        </div>
</div>

@endsection