<?php
/**
 * Created by PhpStorm.
 * User: Le
 * Date: 7/9/2016
 * Time: 6:47 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
    
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function votes()
    {
        return $this->hasMany('App\Models\Vote');
    }
}