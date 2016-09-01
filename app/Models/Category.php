<?php
/**
 * Created by PhpStorm.
 * User: Le
 * Date: 7/9/2016
 * Time: 6:47 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    
    public function topics()
    {
        return $this->hasMany('App\Models\Topic');
    }
    public static function getAllCategories(){
        $categories = self::get();
        return $categories;
    }
}