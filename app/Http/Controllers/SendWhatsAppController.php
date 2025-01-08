<?php

namespace App\Http\Controllers;

use App\Service\WablasService;
use Illuminate\Http\Request;

class SendWhatsAppController extends Controller
{
    protected $wablasService;

    public function __construct(WablasService $wablasService)
    {
        $this->wablasService = $wablasService;
    }

    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'to' => 'required|phone',
            'message' => 'required|string|max:500'
        ]);

        $response = $this->wablasService->sendMessage($validated['to'], $validated['message']);
        return response()->json($response);
    }
}
