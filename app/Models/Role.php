<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Role extends Model
{
    use HasFactory;

    protected $fillable=[
        'name'
    ];

    public function abilities(){
        return $this->hasMany(RoleAblitity::class);
    }

    public static function createWithAbilities(Request $request){

        DB::beginTransaction();

        try{
          $role=Role::create([
            'name' =>$request->post('name'),
            ]);

            foreach($request->post('abilities') as $ability=>$value){
                RoleAblitity::create([
                    'role_id'=>$role->id,
                    'ability'=>$ability,
                    'type'=>$value,
                ]);
            }
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        

        return $role;
    }


    public function updateWithAbilities(Request $request){

        DB::beginTransaction();

        try{
            $this->update([
            'name' =>$request->post('name'),
            ]);

            foreach($request->post('abilities') as $ability=>$value){
                RoleAblitity::updateOrCreate([
                    'role_id'=>$this->id,
                    'ability'=>$ability
                    ],[
                    'type'=>$value,
                ]);
            }
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        

        return $this;
    }
}
