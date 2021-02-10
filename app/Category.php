<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    /**
     * Get the products for the blog category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }


    /**
     * Get the category childrens.
     */
    public function children(){
        return $this->hasMany( 'App\Category', 'parent_id', 'id' );
    }

    /**
     * Get the ccategory parent.
     */
    public function parent(){
        return $this->hasOne( 'App\Category', 'id', 'parent_id' );
    }
}
