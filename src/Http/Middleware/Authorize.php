<?php

namespace Naif\CpanelMail\Http\Middleware;

use Naif\CpanelMail\CpanelMail;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(CpanelMail::class)->authorize($request) ? $next($request) : abort(403);
    }
}
