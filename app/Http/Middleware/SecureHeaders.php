<?php

namespace App\Http\Middleware;

use Closure;

class SecureHeaders
{

    /**
     * Unwanted headers
     *
     * @var array
     */
    private $unwantedHeaderList = [
        'X-Powered-By',
        'Server',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->removeUnwantedHeaders();

        $response = $next($request);

        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Frame-Options', 'sameorigin'); // sameorigin
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        // $response->headers->set('Content-Security-Policy', "default-src 'self'"); // Clearly, you will be more elaborate here.
        $response->headers->set('Feature-Policy', "geolocation 'none'; midi 'none'; camera 'none'; usb 'none'; magnetometer 'none'; accelerometer 'none'; vr 'none'; speaker 'none'; ambient-light-sensor 'none'; gyroscope 'none'; microphone 'none'");

        return $response;
    }

    /**
     * Remove unwanted header
     *
     * @return void
     */
    private function removeUnwantedHeaders()
    {
        foreach ($this->unwantedHeaderList as $header) {
            @header_remove($header);
        }
    }
}
