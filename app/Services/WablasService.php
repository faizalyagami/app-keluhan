<?php

namespace App\Service;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WablasService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('WABLAS_API_URL');
        $this->apiKey = env('WABLAS_API_KEY');
    }

    public function sendMessage($to, $message)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->apiUrl, [
            'phone' => $to,
            'message' => $message,
        ]);

        return $response->json();
    }
}
