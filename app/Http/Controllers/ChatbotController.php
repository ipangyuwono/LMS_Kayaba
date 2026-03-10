<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            $apiKey = env('GROQ_API_KEY');
            if (empty($apiKey)) {
                throw new \Exception('GROQ_API_KEY belum diisi di .env');
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'      => 'llama-3.1-8b-instant',
                'max_tokens' => 1000,
                'messages'   => [
                    [
                        'role'    => 'system',
                        'content' => 'Kamu adalah asisten LMS Kayaba Training Center. Kamu membantu admin dan customer menjawab pertanyaan seputar pelatihan, materi, quiz, progress belajar, dan sertifikat. Jawab dengan ramah, sopan, dan singkat dalam Bahasa Indonesia.',
                    ],
                    [
                        'role'    => 'user',
                        'content' => $request->message,
                    ],
                ],
            ]);

            if ($response->failed()) {
                $status = $response->status();

                if ($status === 429) {
                    return response()->json([
                        'error' => 'Asisten sedang sibuk, tunggu sebentar lalu coba lagi ya 🙏'
                    ], 429);
                }

                Log::error('Groq API Error: ' . $status . ' - ' . $response->body());
                return response()->json([
                    'error' => 'Gagal menghubungi asisten: ' . $status
                ], 500);
            }

            $reply = $response->json('choices.0.message.content')
                ?? 'Maaf, saya tidak mengerti pertanyaanmu.';

            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            Log::error('Chatbot Error: ' . $e->getMessage() . ' | Line ' . $e->getLine());
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
