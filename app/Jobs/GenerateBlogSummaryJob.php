<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateBlogSummaryJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public \App\Models\Blog $blog)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(\App\Services\BlogSummarizerService $summarizer): void
    {
        $summary = $summarizer->summarize($this->blog->body);

        $this->blog->update([
            'summary' => $summary,
        ]);
    }
}
