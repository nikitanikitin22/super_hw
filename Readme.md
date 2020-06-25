### Installation
1. Copy `.env.dist` to `.env` and provide credentials.
2. `docker-compose up`
3. Hit `http://localhost:8080/` in your browser.

OR:

Step one from above, `composer install` and hit `index.php` in your browser. This variant requires PHP 7.4.

### General thoughts
The task is nice and is quite different from the usual homework you get from companies. I'm quite happy with my result,
the only things missing are DI container to clean-up all the boilerplate and redis for token and response caching. But I
already took about ~6-7 hours making this don't want to go over your estimate a lot more. I assume I could cache token 
for 30 minutes and maybe cache the whole posts response for 5 minutes. Another option, especially if app is required to never
fallback on new posts, we could get the first page of results, check the first ID's and only re-fetch if those don't match.
Or even just update our local copy of post data on the newest posts, assuming that posts only get added, never removed.