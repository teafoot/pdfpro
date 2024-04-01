<?php

namespace App\Http\Controllers;

use App\Services\OpenAIService;
use Illuminate\Http\Request;

class OpenAIController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function sendChatMessage(Request $request)
    {
        $prompt = $request->input('message');
        $response = $this->openAIService->completion($prompt);

        return response()->json($response);
    }
}
