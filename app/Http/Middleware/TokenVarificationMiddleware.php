<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use App\Helper\JWTToken;

class TokenVarificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

            $result=JWTToken::varifyToken($request->cookie('token'));

            if($result=="unauthorized"){
                return response()->json(['status'=>'failed','message'=>'unauthorized']);
            }else{
                $request->headers->set('id',$result->userId);
                $request->headers->set('email',$result->userEmail);
                return $next($request);

            }


    }
}
