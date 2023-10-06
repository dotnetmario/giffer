<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Http\Requests\App\HomeFeedRequest;

class HomeController extends Controller
{
    public function home(HomeFeedRequest $request)
    {
        $memes = (new Feed)->homeFeed($request->input('cats'), $request->input('tags'));

        return view('fo/home', compact('memes'));
    }
}
