<?php
namespace App\Http\Middleware;
use Closure;
use Exception;
use App\Models\Users;
use Firebase\JWT\JWT;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $auth = $request->header('Authorization');

        if(!$auth) {
            // Unauthorized response if token not there
            return response()->json([
                'code' => 401,
                'message' => 'Anda tidak memiliki akses, silahkan login kembali ke aplikasi!'
            ], 401);
        }

        try {
            $token = explode(' ', $auth);
            $key = $token[1];
            $credentials = JWT::decode($key, env('JWT_SECRET'), ['HS256']);
            $userId = ((array)$credentials)['user_id'];

            $auth = Users::where([
                ['id', '=', $userId],
                ['token', '=', $key],
                ['token', '>=', date('Y-m-d H:i:s')]
            ])->first();

            $request['user_id'] = $userId;

            if (!$auth) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Anda tidak memiliki akses, silahkan login kembali ke aplikasi!'
                ], 401);
            }
        } catch(Exception $e) {
            return response()->json([
                'code' => 401,
                'message' => 'Anda tidak memiliki akses, silahkan login kembali ke aplikasi!'
            ], 401);
        }

        return $next($request);
    }
}