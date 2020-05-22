<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title', 'text', 'preview_text', 'user_id'];
    /**
     * Prepare a date for array / JSON serialization.
     */
    protected function serializeDate(\DateTimeInterface $date) : string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public static function getAllList(){
        $list = self::orderBy('created_at', 'desc')->get();

        foreach ($list as $key => $value){
            $list[$key]->likes = Likes::getByTableElement('newsTable', $value->id);
        }

        return $list;
    }
}
