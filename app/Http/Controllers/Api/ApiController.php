<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * Martketpaketi API
 */
class OrderResource extends Controller
{
    /**
     * API Name
     *
     * @var string
     */
    private $name;

    /**
     * API Version
     *
     * @var string
     */
    private $version;

    /**
     * API EndPoint URL
     *
     * @var string
     */
    private $endpoint;

    public function __construct()
    {
        $this->name = 'MarketPaketi REST API Service';
        $this->version = 'v1';
        $this->endpoint = url('api');
    }
    
    public function index()
    {
        return response()->json([
            'name'     => $this->name,
            'version'  => $this->version,
            'endpoint' => $this->endpoint,
        ]);
    }
}
