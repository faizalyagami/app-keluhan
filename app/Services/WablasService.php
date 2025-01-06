<?php

namespace App\Service;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WablasService
{
    protected $client;
    protected $apiUrl;
    protected $apiKey;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->apiUrl = config('wablas.api_url');
        $this->apiKey = config('wablas.api_key');
    }

    public function sendMessage($to, $message)
    {
        try {
            $response = $this->client->post($this->apiUrl, [
                'form_params' => [
                    'apiKey' => $this->apiKey,
                    'number' => $to,
                    'message' => $message,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if ($data['status'] == 'success') {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error("Error Sending Wablas: " . $e->getMessage());
            return false;
        }
    }
}
