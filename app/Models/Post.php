<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['postUserid', 'postCategoryid', 'postContent', 'postTime'];

    public function user(){
        return $this->belongsTo('App\User');    
    }

    public function category(){
        return $this->hasOne('App\Category');
    }

    public function likes(){
        return $this->hasMany('App\Like');
    }
}
