@extends('layouts.dashboard')

@section('content')
<div class="main-wrapper">
<style>
    label{
        font-size: 20px;
        display: inline-block;
        width: 200px;
    }
</style>



<div class="page-wrapper">
        <div class="page-content">

            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                
                
                <div class="container justify-content-center ">
                    <h2 style="font-size: 30px;" class="text-right-15 ">Edit Profiel</h2>
                </div>
                <div class="container pt-6 justify-content-center">
                @if($errors->any())

                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </div>
                @endif

                <x-alert type="success" />

                <div>
                    <form action="{{route('userprofile.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        
                        <div class="form-group">
                            <label for="">First Name: &nbsp; </label>
                            <x-form.input class="form-control" name="first_name" value="{{$user->profile->first_name}}"  />
                        </div><br>

                        <div class="form-group">
                            <label for="">Last Name: &nbsp; </label>
                            <x-form.input class="form-control" name="last_name" value="{{$user->profile->last_name}}" />
                        </div><br>

                        <div class="form-group">
                            <label for="">Birthday: &nbsp; </label>
                            <x-form.input class="form-control" name="birthday" type="date" value="{{$user->profile->birthday}}" />
                        </div><br>

                        <div class="form-group">
                            <label for="">Street Address: &nbsp; </label>
                            <x-form.input class="form-control" name="street_address" value="{{$user->profile->street_address}}" />
                        </div><br>

                        <div class="form-group">
                            <label for="">City: &nbsp; </label>
                            <x-form.input class="form-control" name="city" value="{{$user->profile->city}}" />
                        </div><br>

                        <div class="form-group">
                            <label for="">Postal Code: &nbsp; </label>
                            <x-form.input class="form-control" name="postal_code" value="{{$user->profile->postal_code}}" />
                        </div><br>

                        <div class="form-group">
                            <label for="">Country: &nbsp; </label>
                            <x-form.select class="form-control" name="country" :options="$countries" :selected="$user->profile->country" />
                        </div><br>

                        <div class="form-group">
                            <label for="">Locale: &nbsp; </label>
                            <x-form.select class="form-control" name="locale" :options="$locales" :selected="$user->profile->locale" />
                        </div><br> 

                        <div class="form-group">
                            <button type="submit" class="btn btn-danger">Save</button>
                        </div><br>
                    </form>
                </div>
            </div>
        </div>
</div>

@endsection