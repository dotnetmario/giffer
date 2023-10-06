<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class Feed
{
    private $hot_meme_rank;
    private $perpage_count;
    private $home_feed_timespan;
    private $category_feed_timespan;
    private $tag_feed_timespan;

    private $home_feed_cache_time;
    private $category_feed_cache_time;
    private $tag_feed_cache_time;

    public function __construct()
    {
        $this->hot_meme_rank = config('app-conf.hot-meme-rank');
        $this->perpage_count = config('app-conf.perpage-count');
        $this->home_feed_timespan = config('app-conf.home-feed-timespan');
        $this->category_feed_timespan = config('app-conf.category-feed-timespan');
        $this->tag_feed_timespan = config('app-conf.tag-feed-timespan');

        $this->home_feed_cache_time = config('app-conf.home-feed-cache-time');
        $this->category_feed_cache_time = config('app-conf.category-feed-cache-time');
        $this->tag_feed_cache_time = config('app-conf.tag-feed-cache-time');

    }

    /**
     * Home feed, random memes
     * 
     * @param array[int] cats
     * @param array[int] tags
     * 
     * @return Collection
     */
    public function homeFeed($cats = [], $tags = [])
    {
        $cacheKey = 'home_feed_' . implode('_', $cats) . '_' . implode('_', $tags);

        $memes = Cache::remember($cacheKey, now()->addMinutes($this->home_feed_cache_time), function () use ($cats, $tags) {
            return Meme::with(['comments', 'likes'])
                ->where([
                    // only the based memes
                    ['rank', '>=', $this->hot_meme_rank],
                    // fresh memes only
                    ['created_at', '>=', Carbon::now()->subDays($this->home_feed_timespan)],
                ])
                ->orderBy('rank', 'DESC')
                ->when(!empty($tags), function ($query) use ($tags) {
                    return $query->whereHas('tags', function (Builder $query) use ($tags) {
                        $query->whereIn('id', $tags);
                    });
                })
                ->when(!empty($cats), function ($query) use ($cats) {
                    return $query->whereHas('categories', function (Builder $query) use ($cats) {
                        $query->whereIn('id', $cats);
                    });
                })
                ->paginate($this->perpage_count)
                ->inRandomOrder();
        });

        return $memes;
    }


    /**
     * Category feed
     * 
     * @param array[int] cat_id
     * @param array[int] tags
     * 
     * @return Collection
     */
    public function categoryFeed($cat_id, $tags = [])
    {
        $cacheKey = 'category_feed_' . $cat_id . '_' . implode('_', $tags);

        // Attempt to retrieve the result from cache
        $memes = Cache::remember($cacheKey, now()->addMinutes($this->category_feed_cache_time), function () use ($cat_id, $tags) {
            return Category::where('id', (int) $cat_id)
                ->with([
                    'memes' => function (Builder $query) use ($tags) {
                        // check for tags
                        if (!empty($tags)) {
                            $query->whereHas('tags', function (Builder $query) use ($tags) {
                                $query->whereIn('id', $tags);
                            });
                        }
                        $query->orderBy('rank', 'DESC');
                    },
                    'memes.comments',
                    'memes.likes'
                ])
                ->paginate($this->perpage_count);
        });

        return $memes;
    }
}