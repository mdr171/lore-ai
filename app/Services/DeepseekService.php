<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeepseekService
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.deepseek.api_key', env('DEEPSEEK_API_KEY', ''));
        $this->baseUrl = config('services.deepseek.base_url', 'https://api.deepseek.com/v1');
        $this->model = config('services.deepseek.model', 'deepseek-chat');
    }

    public function analyzeChapter(string $content, string $title = ''): ?array
    {
        $systemPrompt = "You are an expert Xianxia / Wuxia novel lore analyst. " .
            "Analyze the given chapter text and return a structured JSON response only. " .
            "Do NOT include markdown wrapping like ```json. Return strict valid JSON with the exact structure:\n" .
            "{\n" .
            '  "chapter_summary": "Short 2-3 sentence summary of what happened.",' . "\n" .
            '  "characters": [\n' .
            '    {"name": "Name", "realm": "Qi Condensation 3rd Layer / etc", "role": "Protagonist/Antagonist/Elder/etc", "faction": "Sect Name or null", "summary": "brief summary", "status": "Alive/Dead/Unknown"}\n' .
            "  ],\n" .
            '  "factions": [\n' .
            '    {"name": "Sect Name", "type": "Righteous Sect / Demonic Sect / Clan", "alignment": "Good/Neutral/Evil", "description": "short summary"}\n' .
            "  ],\n" .
            '  "relationships": [\n' .
            '    {"source": "Character A", "target": "Character B", "type": "Enemy/Master/Disciple/Rival/Ally", "notes": "context of interaction"}\n' .
            "  ],\n" .
            '  "lore_items": [\n' .
            '    {"name": "Item/Technique/Pill", "category": "Artifact/Cultivation Technique/Pill/Location", "description": "details"}\n' .
            "  ]\n" .
            "}";

        $userPrompt = "Chapter Title: {$title}\n\nChapter Content:\n" . substr($content, 0, 8000);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(60)->post($this->baseUrl . '/chat/completions', [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userPrompt],
                ],
                'temperature' => 0.2,
                'response_format' => ['type' => 'json_object'],
            ]);

            if ($response->failed()) {
                Log::error('Deepseek API error: ' . $response->body());
                return null;
            }

            $rawJson = $response->json('choices.0.message.content');
            
            // Clean markdown tags if model ignored system prompt
            $cleanJson = preg_replace('/^```json\s*|\s*```$/i', '', trim($rawJson));

            return json_decode($cleanJson, true);

        } catch (\Exception $e) {
            Log::error('Deepseek service exception: ' . $e->getMessage());
            throw $e;
        }
    }
}
