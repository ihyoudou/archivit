<?php

namespace App\Jobs;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class DownloadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $post_id;
    public $url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post_id, $url)
    {
        $this->post_id = $post_id;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Downloading image
        $original_file = file_get_contents($this->url);
        // Generating sha256 hash of image
        $ctx = hash_init('sha256');
        hash_update($ctx, $original_file);
        $hash = hash_final($ctx);

        // Checking if file exist based on url
        $check_if_exist = Media::where('hash', '=', $hash)->count();
        if($check_if_exist == 0){
            $uuid = Str::uuid();
            $path = sprintf("%s/%s/%s.%s",
                Carbon::now()->format('Y'),
                Carbon::now()->format('m'),
                $uuid,
                pathinfo(basename($this->url), PATHINFO_EXTENSION));

            $image = Image::make($original_file)->encode('webp', 75);
            Storage::put($path, $image);

            $post = Post::where('reddit_id', '=', $this->post_id)->first();
            Media::insert([
                "reddit_post_id" => $post->id,
                "uri" => $path,
                "original_source" => $this->url,
                "type" => "image",
                "hash" => $hash,
            ]);
        }

    }
}
