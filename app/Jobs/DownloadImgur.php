<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DownloadImgur implements ShouldQueue
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
        $array = explode("/", $this->url);
        $gallery_hash = end($array);

        $client = new Client();
        $headers = [
            'Authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID')
        ];
        $request = new Request('GET', 'https://api.imgur.com/3/gallery/image/'.$gallery_hash, $headers);
        $res = $client->sendAsync($request)->wait();
        var_dump($res->getBody());
//        echo $res->getBody();

    }
}
