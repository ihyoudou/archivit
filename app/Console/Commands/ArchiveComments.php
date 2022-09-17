<?php

namespace App\Console\Commands;

use App\Jobs\DownloadGfycat;
use App\Models\Author;
use App\Models\Comments;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;

class ArchiveComments extends Command
{
    private $totalItemsToArchiveCount;
    private $counter = 1;
    private $to_archive;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'archivit:archive-comments';

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

        $this->to_archive = Post::where('locked', 0)
            ->where('created_at', '>=', Carbon::now()->sub('1 month')->toDateTimeString())
            ->get();
        $this->totalItemsToArchiveCount = count($this->to_archive);

        $client = new Client();

        $requests = function($total) use ($client) {
            foreach($this->to_archive as $key=>$item){
                $url = sprintf("https://old.reddit.com%s.json", $item->permalink);
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
                $request = json_decode($response->getBody())[1];
                $comments = array();
                foreach($request->data->children as $one) {
                    // Making sure that is it a comment
                    if($one->kind === "t1"){
                        $data = $one->data;
                        $author = Author::firstOrCreate([
                            'name' => $data->author
                        ]);

                        $comments[] = [
                            "rid" => $data->name,
                            "parent_id" => $data->parent_id,
                            "body" => $data->body,
                            "reddit_post_id" => $this->to_archive[$index]->id,
                            "author_id" => $author->id,
                            "upvotes" => $data->ups,
                            "downvotes" => $data->downs,
                            "score" => $data->score,
                            "created_at" => Carbon::createFromTimestamp($data->created_utc),
                        ];

                        // Updating existing posts that are still on the list
                        $votes_update = Comments::where("rid", '=', $data->id)->update(
                            [
                                "upvotes" => $data->ups,
                                "downvotes"=> $data->downs,
                                "score" => $data->score,
                                "updated_at" => Carbon::now(),
                            ]
                        );
                        if(isset($data->replies->data->children)) {
                            foreach ($data->replies->data->children as $replies) {
                                if($replies->kind === "t1"){
                                    $author = Author::firstOrCreate([
                                        'name' => $replies->data->author
                                    ]);
                                    $comments[] = [
                                        "rid" => $replies->data->name,
                                        "parent_id" => $replies->data->parent_id,
                                        "body" => $replies->data->body,
                                        "reddit_post_id" => $this->to_archive[$index]->id,
                                        "author_id" => $author->id,
                                        "upvotes" => $replies->data->ups,
                                        "downvotes" => $replies->data->downs,
                                        "score" => $replies->data->score,
                                        "created_at" => Carbon::createFromTimestamp($replies->data->created_utc),
                                    ];

                                    $votes_update = Comments::where("rid", '=', $data->name)->update(
                                        [
                                            "upvotes" => $replies->data->ups,
                                            "downvotes" => $replies->data->downs,
                                            "score" => $replies->data->score,
                                            "updated_at" => Carbon::now(),
                                        ]
                                    );
                                }
                            }
                        }
                    }
                }
                // Mass insert
                $insert = Comments::insertOrIgnore($comments);
                $this->info(sprintf("%d new comments archived on %s", $insert, $this->to_archive[$index]->title));
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
