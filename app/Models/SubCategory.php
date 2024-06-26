<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
    {
    protected $table="sub_categories";
    protected $fillable = array('category_id','name','img','slug');
    // protected $fillable = array('category_id','name','img','slug', 'commission');

    
    public function categories(){
    	return $this->belongsTo(Category::class, 'category_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'subcategory_id');
    }
    

    public function subcategory()
    {
        return $this->belongsTo('App\Models\SubCategory', 'subcategory_id');
    }
    }

