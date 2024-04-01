<?php

namespace App\Http\Controllers;

use App\Services\OllamaService;
use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;

class OllamaController extends Controller
{
    protected $ollamaService;

    public function __construct(OllamaService $ollamaService)
    {
        $this->ollamaService = $ollamaService;
    }

    public function sendChatMessage(Request $request)
    {
        try {
            $prompt = $request->input('message');
            $response = $this->ollamaService->completion($prompt);
            return response()->json($response);
        } catch (ConnectionException $e) {
            return response()->json(['error' => 'The request to Ollama service timed out.'], 504);
        }
    }
}
