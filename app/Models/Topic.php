<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    const STATUS_SOLVED = 'solved';
    const STATUS_OPEN = 'open';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function votes()
    {
        return $this->hasMany('App\Models\Vote');
    }

    public static function getAllStatus(){
        $arr = [
            self::STATUS_OPEN => self::getStatusLabel(self::STATUS_OPEN),
            self::STATUS_SOLVED => self::getStatusLabel(self::STATUS_SOLVED)
        ];
        return $arr;

    }
    public static function getStatusLabel($code){
        switch ($code){
            case self::STATUS_SOLVED:
                return 'SOLVED';
            case self::STATUS_OPEN:
                return 'OPEN';
        }
    }
}
