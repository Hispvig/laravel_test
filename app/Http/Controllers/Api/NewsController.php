<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Likes;
use App\Model\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class NewsController extends Controller
{
    public function __construct()
    {
        if (!in_array(Route::currentRouteName(), ['api.news.index', 'api.news.show'])) {
            $this->middleware('auth');
        }
    }

    public function index()
    {

        return News::getAllList();

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'text' => 'required',
            'preview_text' => 'required|max:500',
        ]);

        $request->request->add(['user_id' => Auth::user()->id]);

        $news = News::create($request->all());
        return $news;
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        if($news){
            $news->likes = Likes::getByTableElement('newsTable', $id);
        }

        return $news;
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        if (Auth::user()->id == $news->user_id) {

            $request->validate([
                'title' => 'required|max:255',
                'text' => 'required',
                'preview_text' => 'required|max:500',
            ]);

            $news->update($request->all());

            return $news;
        } else {
            return ['error' => 'Вы не являетесь владельцем данной новости'];
        }

    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        if (Auth::user()->id == $news->user_id) {

            $news->delete();
            return '';
        } else {
            return ['error' => 'Вы не являетесь владельцем данной новости'];
        }
    }
}
