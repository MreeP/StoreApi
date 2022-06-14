<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthTokenParseMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        $token = DB::table('api_tokens')
            ->where('token', $request->get('token'))
            ->where('valid_thru', '>=', now())
            ->first();

        if ($token) {
            auth()->setUser(User::where('id', $token->user_id)->first());
        }

        return $next($request);
    }
}
