<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function create_lead(Request $request)
    {
        $post_data = [
            'name' => [$request->name],
            'price' => [$request->price]
        ];
        $client = new Client(['base_uri' => env('BASE_URL')]);
        try {

            $client_data = $client->post('/api/v4/leads', [
                'body' => json_encode($post_data),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . env('ACCESS_TOKEN')
                ]
            ]);
            $body = json_decode($client_data->getBody());
            return [
                'success' => true,
                'success_code' => 200,
                'data' => $body
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error_code' => $e->getCode(),
                'error_message' => json_encode($e->getMessage())
            ];
        }
    }
}
