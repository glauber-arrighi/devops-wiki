<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        if (!$request->user()->active) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => 'Conta desativada.']);
        }

        if (empty($roles) || in_array($request->user()->role?->name, $roles)) {
            return $next($request);
        }

        abort(403, 'Acesso não autorizado.');
    }
}
