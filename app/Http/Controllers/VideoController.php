<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function upload(Channel $channel)
    {
        return view('channel.upload', compact('channel'));
    }

    public function store(Channel $channel)
    {
        return $channel->videos()->create([
            'title' => request()->title,
            'path' => request()->video->store("channels/{$channel->id}")
        ]);
    }
}
