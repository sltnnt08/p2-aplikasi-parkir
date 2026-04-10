<?php

namespace App\Http\Middleware;

use App\Models\LogAktivitas;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userIdBeforeRequest = Auth::id();

        try {
            $response = $next($request);
        } catch (Throwable $throwable) {
            if ($userIdBeforeRequest) {
                $this->storeLog($userIdBeforeRequest, $this->buildExceptionActivity($request, $throwable));
            }

            throw $throwable;
        }

        $userIdAfterRequest = Auth::id();
        $userId = $userIdAfterRequest ?? $userIdBeforeRequest;

        if (! $userId) {
            return $response;
        }

        $activity = $this->resolveActivity($request, $response, $userIdAfterRequest !== null);

        if ($activity !== null) {
            $this->storeLog($userId, $activity);
        }

        return $response;
    }

    private function resolveActivity(Request $request, Response $response, bool $authenticatedAfterRequest): ?string
    {
        if ($request->isMethod('post') && $request->is('login') && $authenticatedAfterRequest) {
            return 'Login';
        }

        if ($request->routeIs('logout') && $request->isMethod('post')) {
            return 'Logout';
        }

        $target = $request->route()?->getName() ?: '/'.$request->path();

        return Str::limit(
            sprintf('%s %s [%d]', $request->method(), $target, $response->getStatusCode()),
            100,
            ''
        );
    }

    private function buildExceptionActivity(Request $request, Throwable $throwable): string
    {
        $statusCode = method_exists($throwable, 'getStatusCode')
            ? (int) $throwable->getStatusCode()
            : 500;

        $target = $request->route()?->getName() ?: '/'.$request->path();

        return Str::limit(
            sprintf('%s %s [%d]', $request->method(), $target, $statusCode),
            100,
            ''
        );
    }

    private function storeLog(int $userId, string $activity): void
    {
        try {
            LogAktivitas::create([
                'id_user' => $userId,
                'aktivitas' => $activity,
                'waktu_aktivitas' => now(),
            ]);
        } catch (Throwable $throwable) {
            report($throwable);
        }
    }
}
