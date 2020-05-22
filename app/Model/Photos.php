<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    protected $fillable = ['name', 'user_id'];

    public static function getAllList(){
        $list = self::orderBy('created_at', 'desc')->get();

        foreach ($list as $key => $value){
            $list[$key]['name'] = '/storage/' . $value->name;
            $list[$key]->likes = Likes::getByTableElement('photosTable', $value->id);
        }

        return $list;
    }
}
