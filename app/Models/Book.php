<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','author','published_date','user','is_borrowed','category_id','deleted_at'];


    public function category(){
        return $this->belongsTo(Category::class);
    }
}
