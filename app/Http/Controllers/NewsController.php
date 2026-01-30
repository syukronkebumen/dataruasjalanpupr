<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'User-Agent' => 'Laravel/10 NewsApp'
        ])->get('https://newsapi.org/v2/everything', [
            'domains' => 'wsj.com',
            'apiKey' => env('NEWS_API_KEY'),
        ]);

        return response()->json($response->json());
    }
}
