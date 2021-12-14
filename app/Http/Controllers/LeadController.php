<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    protected $link_data;

    public function __construct()
    {
        $this->link_data = new TokenController();
    }

    public function create_lead(Request $request)
    {
        $post_data = [
            'name' => [$request->name],
            'price' => [$request->price]
        ];
        $post_info = $this->link_data->get_token();

        $client = new Client(['base_uri' => 'https://'.$post_info['base_url']]);
        try {

            $client_data = $client->post('/api/v4/leads', [
                'body' => json_encode($post_data),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $post_info['access_token']
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
