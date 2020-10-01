<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;
use App\Models\Category;

class Category extends Model
{


    use SoftDeletes;

    protected $guarded = [''];


    protected $dates = ['deleted_at'];

    public function products() {

        return $this->belongsToMany('App\Models\Product');
    }

    public function childrens() {

        return $this->belongsToMany(Category::class, 'category_parent', 'category_id', 
        'parent_id');
    }

}
