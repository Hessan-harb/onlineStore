<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

     protected $guarded=[];

     protected $hidden=[
        'created_at','deleted_at','updated_at','image'
     ];

     protected $appends=[
        'image_url',
     ];

     public function scopeFilterr(Builder $builder,$filter){

        $builder->when($filter['name'] ?? false ,function($builder,$value){
            $builder->where('products.name','LIKE',"%{$value}%");
        });

        // if($filter['name'] ?? false) {

        //     $builder->where('name','LIKE',"%{$filter['name']}%");
        // }
    }

    protected static function booted()
    {
        static::addGlobalScope('store',function(Builder $builder){
            $user=Auth::user();
            if($user && $user->store_id){
                $builder->where('store_id','=',$user->store_id);
            }
        });

        static::creating(function(Product $product){
            $product->slug=Str::slug($product->name);
        });
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function store(){
        return $this->belongsTo(Store::class,'store_id','id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class,'product_tag','product_id','tag_id','id','id');
    }

    public function scopeActive(Builder $builder){
        $builder->where('status','=','active');
    }

    public function getImageUrlAttribute(){

        if(!$this->image){
            return 'https://www.incathlab.com/images/products/default_product.png';
        }

        if(Str::startsWith($this->imgae,['http://','https://'])){
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    public function getSalePercentAttribute(){
        if(!$this->compare_price){
            return 0;
        }
        return round(100 - (100 * $this->price / $this->compare_price),1);
    }

    public function scopeFilter(Builder $builder,$filters){

        $options=array_merge([
            'store_id'=>null,
            'category_id'=>null,
            'tag_id'=>null,
            'status'=>'active',
        ],$filters);

        $builder->when($options['status'],function($query,$status){
            return $query->where('status',$status);
        });

        $builder->when($options['store_id'],function($builder,$value){
            $builder->where('store_id',$value);
        });

        $builder->when('category_id',function($builder,$value){
            $builder->where('category_id',$value);
        });

        $builder->when($options['tag_id'],function($builder,$value){

            $builder->whereExists(function($query) use ($value){
                $query->select(1)
                    ->from('product_tag')
                    ->whereRaw('product_id = products.id')
                    ->where('tag_id',$value);
            });

            // $builder->whereRaw('id IN (SELECT product_id FROM product_tage WHERE tag_id = ?)',[$value]);
            // $builder->whereRaw('EXISTS (SELECT 1 FROM product_tage WHERE tag_id = ? AND product_id = products.id)',[$value]);

            // $builder->whereHas('tags',function($builder) use ($value){
            //     $builder->where('id',$value);
            // });
        });
    }

    
}
