<?php

namespace App\Http\Middleware;

use App\Redirection;
use Closure;

class RedirectionCheck
{
    /**
     * Gelen istekleri redirections tablosundan
     * kontrol eder ve yeni bir url
     * eklendi ise 301 olarak o adrese yönlendirir.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $fullUrl = $request->url();
        $uri     = $request->getRequestUri();

        $url      = str_replace(['http://', 'https://'], ['', ''], $fullUrl);
        $httpUrl  = 'http://' . $url;
        $httpsUrl = 'https://' . $url;

        // Anasayfa ve admin paneli haricindeki linkleri kontrol et
        if (!$request->is('/') && !$request->is('admin') && !$request->is('admin/*')) {
            $findRedirection = Redirection::where('oldUrl', $httpUrl)
                ->orWhere('oldUrl', $httpsUrl)
                ->orWhere('oldUrl', $url)
                ->select('newUrl')
                ->first();

            if ($findRedirection) {
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

                $newUrl = $protocol . str_replace(['http://', 'https://'], ['', ''], $findRedirection->newUrl);
                return redirect($newUrl, 301);
            }
        }

        return $next($request);
    }
}
