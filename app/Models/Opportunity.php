<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = ['oppCategoryid', 'oppUserid', 'companyName', 'jobTitle', 'dueDate', 'companyImage', 'companyLink', 'description', 'postTime'];

    public function user(){
        return $this->belongsTo('App\User');    
    }

    public function category(){
        return $this->hasOne('App\Category');
    }
}
