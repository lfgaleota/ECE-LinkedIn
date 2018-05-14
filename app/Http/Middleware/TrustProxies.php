<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Config\Repository;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array
     */
    protected $proxies;

    /**
     * The current proxy header mappings.
     *
     * @var array
     */
    protected $headers = [
        Request::HEADER_FORWARDED => 'FORWARDED',
        Request::HEADER_X_FORWARDED_FOR => 'X_FORWARDED_FOR',
        Request::HEADER_X_FORWARDED_HOST => 'X_FORWARDED_HOST',
        Request::HEADER_X_FORWARDED_PORT => 'X_FORWARDED_PORT',
        Request::HEADER_X_FORWARDED_PROTO => 'X_FORWARDED_PROTO',
    ];

    public function __construct(Repository $config) {
        parent::__construct($config);

        if (App::environment('heroku')) {
            $this->proxies = '**';
            $this->headers = [
                Request::HEADER_X_FORWARDED_FOR => 'X_FORWARDED_FOR',
                Request::HEADER_X_FORWARDED_PORT => 'X_FORWARDED_PORT',
                Request::HEADER_X_FORWARDED_PROTO => 'X_FORWARDED_PROTO',
	            Request::HEADER_FORWARDED => null,
	            Request::HEADER_X_FORWARDED_HOST  => null,
            ];
        }
    }
}
