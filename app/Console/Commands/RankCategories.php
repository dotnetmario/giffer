<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class RankCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ranks:category {months? : Number of months for the time span}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-calculates the ranks of each category based on likes and comments for a given timespan';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $months = $this->argument('months');

        if ($months === null) {
            $categories = Category::with([
                'memes',
                'memes.likes',
                'memes.comments'
            ])->get();
        } else {
            $startDate = Carbon::now()->subMonths($months);

            // Retrieve categories with memes within the specified time span
            $categories = Category::with([
                'memes' => function ($query) use ($startDate) {
                    $query->where('created_at', '>=', $startDate);
                },
                'memes.likes',
                'memes.comments'
            ])->get();
        }

        $this->info('Starting');
        foreach ($categories as $category) {
            $this->info('<=================== Working on category ' . $category->id . ' ===================>');
            $rank = 0;

            foreach ($category->memes as $meme) {
                $rank += $meme->likes->count(); // Total likes for the meme
                $rank += $meme->comments->pluck('user_id')->unique()->count(); // Unique commenter count
            }

            // Update the rank in the database
            $category->update(['rank' => $rank]);
        }

        $this->info('Ranks recalculated successfully for the last ' . $months . ' months.');
    }
}