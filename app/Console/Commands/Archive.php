<?php

namespace App\Console\Commands;

use App\Models\ArchiveList;
use App\Models\Author;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class Archive extends Command
{
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
        $to_archive = ArchiveList::all();
        foreach($to_archive as $archive){
            # Setting up the URL
            if($archive->type === "user"){
                $url = sprintf("https://old.reddit.com/user/%s.json?limit=100", $archive->name);
            } elseif($archive->type === "subreddit"){
                $url = sprintf("https://old.reddit.com/r/%s.json?limit=100", $archive->name);
            }
            # Making request
            $request = json_decode(Http::get($url)->getBody());
            # Data formatting
            $posts = array();
            foreach($request->data->children as $one){
                $data = $one->data;
                # Checking if author exists
                # todo: what if user is deleted
                $author = Author::firstOrCreate([
                    'name' => $data->author
                ]);

                $posts[] = [
                    "reddit_id" => $data->id,
                    "title" => $data->title ?? $data->link_title,
                    "selftext" => $data->selftext ?? $data->body_html,
                    "author_id" => $author->id,
                    "source_id" => $archive->id,
                    "permalink" => $data->permalink,
                    "upvotes" => $data->ups,
                    "downvotes" => $data->downs,
                    "locked" => $data->locked,
                    "created_at" => Carbon::createFromTimestamp($data->created),
                    "updated_at" => Carbon::now()
                ];
                # Updating existing posts that are still on the list
                Post::where("reddit_id", '=', $data->id)->update(
                   [
                       "upvotes" => $data->ups,
                       "downvotes"=> $data->downs,
                       "locked" => $data->locked,
                       "updated_at" => Carbon::now(),
                   ]
                );
            }
            # Mass insert
            $insert = Post::insertOrIgnore($posts);
            echo(sprintf("%d new posts archived on %s (%s)", $insert, $archive->name, $archive->type) . PHP_EOL);

        }
        return 0;
    }
}
