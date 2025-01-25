<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVarificationAPIMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $result=JWTToken::varifyToken($request->header('token'));
        if($result=="unauthorized"){
            return response()->json(['status'=>'failed','message'=>'unauthorized']);
        }else{
            $request->headers->set('id',$result->userId);
            $request->headers->set('email',$result->userEmail);
            return $next($request);
        }

    }
}
