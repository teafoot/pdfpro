<?php

namespace App\Services;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;

class OllamaService
{
    private PendingRequest $client;

    public function __construct(PendingRequest $client)
    {
        $client->timeout(120);
        $client->baseUrl(config('services.ollama.urls.base'));
        $client->withHeaders([
            'Authorization' => 'Bearer ' . config('services.ollama.key'),
            'Content-Type' => 'application/json',
        ]);
        $this->client = $client;
    }

    public function completion($prompt, $model = 'dolphin-mistral')
    {
        $completionUrl = config('services.ollama.urls.completion');

        $response = $this->client->post($completionUrl,
            [
                'stream' => false,
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a chat pdf application.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                // 'temperature' => 0.5,
                // 'max_tokens' => 1000,
                // 'top_p' => 0.5,
                // 'frequency_penalty' => 0.5,
                // 'presence_penalty' => 0.5,
            ]);

        \Log::info('Ollama response:', [
            'body' => $response->body()
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        \Log::error('Ollama request failed:', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);
        
        return [];
    }

    // public function textToSpeech($text): PromiseInterface|Response
    // {
    //     return $this->client->post(config('services.openai.urls.text-to-speech'),
    //         [
    //             'model' => config('services.openai.models.tts-1'),
    //             'input' => $text,
    //             'voice' => 'alloy',
    //         ]);
    // }

    // public function images($prompt)
    // {
    //     return $this->client->post(config('services.openai.urls.images'),
    //         [
    //             'prompt' => $prompt,
    //             'n' => 1,
    //             'size' => '512x512',
    //         ])->json();
    // }
}
