<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\TokenMismatchException;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
     protected $except = [
         //
         'pay2go/callback', 'purchase/result', 'purchase/notify'
     ];

     public function handle($request, Closure $next)
     {
         //add this condition
         foreach($this->except as $route) {

             if ($request->is($route)) {
                 return $next($request);
             }
          }

          return parent::handle($request, $next);
     }
}
