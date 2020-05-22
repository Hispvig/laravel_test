<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Likes;
use App\Model\News;
use App\Model\Photos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PhotosController extends Controller
{
    public function __construct()
    {
        if (!in_array(Route::currentRouteName(), ['api.photos.index', 'api.photos.show'])) {
            $this->middleware('auth');
        }
    }

    public function index()
    {
        return Photos::getAllList();
    }


    public function store(Request $request)
    {
        $path = $request->file('image')->store('images', 'public');

        $photo = Photos::updateOrCreate([
            'name' => $path,
            'user_id' => Auth::user()->id,
        ]);

        $photo->name = '/storage/'. $photo->name;

        return $photo;

    }

    public function show($id)
    {
        $photo = Photos::findOrFail($id);
        if($photo){
            $photo->likes = Likes::getByTableElement('photosTable', $id);
            $photo->name = '/storage/' . $photo->name;
        }

        return $photo;
    }

    public function destroy($id)
    {
        $photo = Photos::findOrFail($id);
        if (Auth::user()->id == $photo->user_id) {

            $photo->delete();
            return '';
        } else {
            return ['error' => 'Вы не являетесь владельцем данной новости'];
        }
    }
}
