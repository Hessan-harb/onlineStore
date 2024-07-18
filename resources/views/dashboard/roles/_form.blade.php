
<style>
    label{
        font-size: 20px;
        display: inline-block;
        width: 200px;
    }
</style>
@if($errors->any())

<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
</div>
@endif

<div class="form-group">
    <label for="">Role Name: &nbsp; </label>
    <x-form.input name="name" value="{{$role->name}}" />
</div><br>

<fieldset>
    <legend>Abilities</legend>
    @foreach(config('abilites') as $ability_code=>$ability_name)
    <div class="row md-2">
      <div class="col-md-6">
        {{$ability_name}}
        </div>
        <div class="col-md-2">
            <input type="radio" name="abilities[{{$ability_code}}]" value="allow" @checked(($role_abilities[$ability_code] ?? '') == 'allow') > Allow
        </div>
        <div class="col-md-2">
            <input type="radio" name="abilities[{{$ability_code}}]" value="deny" @checked(($role_abilities[$ability_code] ?? '') == 'deny') > Deny
        </div>
        <div class="col-md-2">
            <input type="radio" name="abilities[{{$ability_code}}]" value="inherit" @checked(($role_abilities[$ability_code] ?? '') == 'inherit') > Inherit
        </div>  
    </div>
    



    

    @endforeach
</fieldset>

<div class="form-group">
    <button class="btn btn-primary" type="submit">Save</button>
</div><br>