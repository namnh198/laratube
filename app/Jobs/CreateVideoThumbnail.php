<?php

namespace App\Jobs;

use App\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateVideoThumbnail implements ShouldQueue
{
    public $video;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \FFMpeg::fromDisk('local')
            ->open($this->video->path)
            ->getFrameFromSeconds(1)
            ->export()
            ->toDisk('local')
            ->save("public/thumbnails/{$this->video->id}.png");

        $this->video->update([
            'thumbnail' => Storage::url("public/thumbnails/{$this->video->id}.png")
        ]);
    }
}
