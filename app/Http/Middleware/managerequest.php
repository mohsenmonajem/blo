<?php
use Symfony\Component\HttpKernel\Exception\HttpException;
namespace App\Http\Middleware;

use Closure;

class managerequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
