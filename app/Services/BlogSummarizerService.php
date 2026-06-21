<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BlogSummarizerService
{
    public function summarize(string $body): string
    {
        $text = trim(strip_tags($body));
        if (empty($text)) {
            return 'This blog post has no readable content to summarize.';
        }

        $accountId = config('services.cloudflare.account_id');
        $apiToken = config('services.cloudflare.api_token');
        $model = config('services.cloudflare.model');

        if (!$accountId || !$apiToken) {
            Log::warning('Cloudflare Workers AI credentials not found. Falling back to local summarizer.');
            return $this->generateLocalFallbackSummary($text);
        }

        try {
            $response = Http::withToken($apiToken)
                ->timeout(15)
                ->post("https://api.cloudflare.com/client/v4/accounts/{$accountId}/ai/run/{$model}", [
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a professional blog post summarizer. Generate a concise, high-quality summary of the post in exactly 3 clear bullet points (each starting with a dash "-"). Do not include any greeting, introduction, or signature, just the 3 bullet points.'
                        ],
                        [
                            'role' => 'user',
                            'content' => "Summarize this blog post:\n\n" . Str::limit($text, 4000)
                        ]
                    ]
                ]);

            if ($response->successful()) {
                $result = $response->json();
                $summaryText = $result['result']['response'] ?? '';
                if (!empty($summaryText)) {
                    return trim($summaryText);
                }
            }

            Log::error('Cloudflare Workers AI API failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Error calling Cloudflare Workers AI: ' . $e->getMessage());
        }

        return $this->generateLocalFallbackSummary($text);
    }

    private function generateLocalFallbackSummary(string $text): string
    {
        // Simple sentence splitter by period, exclamation, or question mark
        $sentences = preg_split('/(?<=[.!?])\s+/', $text);
        $sentences = array_filter(array_map('trim', $sentences), function($sentence) {
            return strlen($sentence) > 15;
        });

        // Normalize text by removing excessive whitespaces/newlines
        $sentences = array_map(function($s) {
            return preg_replace('/\s+/', ' ', $s);
        }, $sentences);

        $bullets = array_slice($sentences, 0, 3);

        if (count($bullets) < 3) {
            $words = explode(' ', $text);
            $bullets = [
                implode(' ', array_slice($words, 0, min(15, count($words)))) . '...',
                implode(' ', array_slice($words, 15, min(15, count($words)))) . '...',
                implode(' ', array_slice($words, 30, min(15, count($words)))) . '...'
            ];
        }

        return "- " . implode("\n- ", $bullets);
    }
}
