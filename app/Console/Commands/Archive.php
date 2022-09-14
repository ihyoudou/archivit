<?php

namespace App\Console\Commands;

use App\Models\ArchiveList;
use App\Models\Author;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use App\Jobs\DownloadImage;

class Archive extends Command
{
    private $totalItemsToArchiveCount;
    private $counter = 1;
    private $to_archive;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'archivit:archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive subreddits and users from database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Initializing...");

        $this->to_archive = ArchiveList::where('type', 'subreddit')->get();
        $this->totalItemsToArchiveCount = count($this->to_archive);
        
        $client = new Client();

        $requests = function($total) use ($client) {
            foreach($this->to_archive as $key=>$item){
                $url = sprintf("https://old.reddit.com/r/%s.json?limit=100", $item->name);
                yield function() use ($client, $url){
                    return $client->getAsync($url);
                };
            }
        };

        $this->info(sprintf("Queued %d jobs", $this->totalItemsToArchiveCount));

        $pool = new Pool($client, $requests($this->totalItemsToArchiveCount), [
            'concurrency' => env('ARCHIVER_CONCURRENT_REQUESTS', 5),
            'fulfilled' => function($response, $index){
                $this->executedCount();
                $request = json_decode($response->getBody());
                $posts = array();
                foreach($request->data->children as $one){
                    $data = $one->data;
                    // Checking if author exists
                    // todo: what if user is deleted
                    $author = Author::firstOrCreate([
                        'name' => $data->author
                    ]);
    
                    $posts[] = [
                        "reddit_id" => $data->id,
                        "title" => $data->title ?? $data->link_title,
                        "selftext" => $data->selftext ?? $data->body_html,
                        "author_id" => $author->id,
                        "source_id" => $this->to_archive[$index]->id,
                        "permalink" => $data->permalink,
                        "upvotes" => $data->ups,
                        "downvotes" => $data->downs,
                        "locked" => $data->locked,
                        "created_at" => Carbon::createFromTimestamp($data->created),
                        "updated_at" => Carbon::now()
                    ];
                    // Updating existing posts that are still on the list
                    $votes_update = Post::where("reddit_id", '=', $data->id)->update(
                        [
                            "upvotes" => $data->ups,
                            "downvotes"=> $data->downs,
                            "locked" => $data->locked,
                            "updated_at" => Carbon::now(),
                        ]
                    );

                    if(isset($data->post_hint) && $data->post_hint === "image"){
                        DownloadImage::dispatch($data->id, $data->url_overridden_by_dest);
                    }
                }
                // Mass insert
                $insert = Post::insertOrIgnore($posts);
                $this->info(sprintf("%d new posts archived on %s (%s)", $insert, $this->to_archive[$index]->name, $this->to_archive[$index]->type));
            },
            'rejected' => function($reason, $index){
                $this->executedCount();
                $this->error("rejected: ".$reason);

            },
        ]);

        $promise = $pool->promise();
        $promise->wait();
        $this->info(sprintf("Executed %d request", $this->counter));

        return 0;
    }

    /**
     * Counter
     *
     * @return void
     */
    public function executedCount()
    {
        if($this->counter < $this->totalItemsToArchiveCount){
            $this->counter++;
            return;
        }
    }
}
