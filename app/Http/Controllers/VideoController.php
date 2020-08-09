<?php

namespace App\Http\Controllers;

use App\Video;
use App\Channel;
use App\Jobs\ConvertForStreaming;
use App\Jobs\CreateVideoThumbnail;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show(Video $video)
    {
        return $video;
    }

    public function upload(Channel $channel)
    {
        return view('channel.upload', compact('channel'));
    }

    public function store(Channel $channel)
    {
        $video = $channel->videos()->create([
            'title' => request()->title,
            'path' => request()->video->store("channels/{$channel->id}")
        ]);

        $this->dispatch(new CreateVideoThumbnail($video));

        $this->dispatch(new ConvertForStreaming($video));

        return $video;
    }
}
