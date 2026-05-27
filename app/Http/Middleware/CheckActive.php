<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class CheckActive
{
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->user() && !$request->user()->active) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => 'Conta desativada.']);
        }
        return $next($request);
    }
}
