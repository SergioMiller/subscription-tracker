<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Entities\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->setUserResolver(fn () => User::query()->first());

        return $next($request);
    }
}
