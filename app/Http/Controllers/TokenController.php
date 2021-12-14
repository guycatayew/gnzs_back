<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use function Symfony\Component\String\b;

class TokenController extends Controller
{
    public function get_token()
    {
        $client = new Client(['base_uri' => 'https://test.gnzs.ru/oauth/get-token.php']);
        try {

            $client_data = $client->get('', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Client-Id' => env('Client_Id')
                ]
            ]);
            $body = json_decode($client_data->getBody());
            return [
                'success' => true,
                'access_token' => $body->access_token,
                'base_url' => $body->base_domain,
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
