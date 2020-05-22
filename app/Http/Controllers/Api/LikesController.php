<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Likes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{

    public function store(Request $request)
    {
        if(in_array($request->table, Likes::TABLES_LIST)) {
            return Likes::editUserLikes((int)Auth::id(), $request->table, (int)$request->element_id);
        }

        return ['error' => 'Неверный формат передаваемых данных'];
    }

    public function destroy($table, $id)
    {
        if(in_array($table, Likes::TABLES_LIST)) {
            return Likes::deleteUserLikes((int)Auth::id(), $table, (int)$id);
        }

        return ['error' => 'Неверный формат передаваемых данных'];
    }
}
