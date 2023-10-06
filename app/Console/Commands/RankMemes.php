<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Meme;

class RankMemes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ranks:meme {months? : Number of months for the time span}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-calculates the ranks of each meme based on likes and comments for a given timespan';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $months = $this->argument('months');

        if ($months === null) {
            $memes = Meme::with([
                'likes',
                'comments'
            ])->get();
        } else {
            $startDate = Carbon::now()->subMonths($months);

            // Retrieve memes with memes within the specified time span
            $memes = Meme::with([
                'likes',
                'comments'
            ])
                ->where('created_at', '>=', $startDate)
                ->get();
        }

        $this->info('Starting');
        foreach ($memes as $meme) {
            $this->info('<=================== Working on meme ' . $meme->id . ' ===================>');
            $rank = 0;

            $rank += $meme->likes->count(); // Total likes for the meme
            $rank += $meme->comments->pluck('user_id')->unique()->count(); // Unique commenter count

            // Update the rank in the database
            $meme->update(['rank' => $rank]);
        }

        $this->info('Ranks recalculated successfully for the last ' . $months . ' months.');
    }
}