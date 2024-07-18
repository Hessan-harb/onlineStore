<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'name',
        'description',
        'image',
        'slug',
        'parent_id'
    ];

    //to 7.4

    public function scopeFilter(Builder $builder,$filter){

        $builder->when($filter['name'] ?? false ,function($builder,$value){
            $builder->where('categories.name','LIKE',"%{$value}%");
        });

        // if($filter['name'] ?? false) {

        //     $builder->where('name','LIKE',"%{$filter['name']}%");
        // }
    }

    public function products(){
        return $this->hasMany(Product::class,'category_id','id');
    }

    public function parent(){
        return $this->belongsTo(Category::class,'parent_id','id');
    }

    public function child(){
        return $this->hasMany(Category::class,'parent_id','id');
    }

    // protected $guarded=[];
}
