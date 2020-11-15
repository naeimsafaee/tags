<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model{
    use HasFactory;

    protected $fillable = ["name" , "slug" , "description" , "image_id"];

    public function products(){
        return $this->morphedByMany(Product::class, 'taggable');
    }

    public function articles(){
        return $this->morphedByMany(Article::class, 'taggable');
    }

    public function image(){
        return $this->hasOne(Image::class);
    }

}
