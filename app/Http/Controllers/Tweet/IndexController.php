<?php

namespace App\Http\Controllers\Tweet;

use App\Http\Controllers\Controller;
use App\Services\TweetService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, TweetService $tweetService)
    {
	   // return 'test1';
	   // $tweetService = new TweetService();
	    $tweets = $tweetService->getTweets();
	    //dump($tweets);
        //app(\App\Exceptions\Handler::class)->render(request(), throw new \Error('dump report.'));
        return view('tweet.index')
            ->with('tweets', $tweets);
    }
}
