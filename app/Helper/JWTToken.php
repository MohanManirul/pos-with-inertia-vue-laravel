<?php

namespace App\Helper;
use Firebase\JWT\JWT;
use Exception;
use Firebase\JWT\key;

class JWTToken{
    public static function createToken($userEmail,$userId){
        $key=env('JWT_KEY');
        $payload=[
            'iss'=>'laravel-token',
            'iat'=>time(),
            'exp'=>time()+60*60,
            'userEmail'=>$userEmail,
            'userId'=>$userId
        ];
        return JWT::encode($payload,$key,'HS256');
    }

    public static function createOtpToken($userEmail){
        $key=env('JWT_KEY');
        $payload=[
            'iss'=>'laravel-token',
            'iat'=>time(),
            'exp'=>time()+60*60,
            'userEmail'=>$userEmail,
            'userId'=>'0'
        ];
        return JWT::encode($payload,$key,'HS256');
    }

    public static function varifyToken($token){
        try{
            if($token==null){
                return "unauthorized";
            }
            $key=env('JWT_KEY');
            $decode=JWT::decode($token,new Key($key,'HS256'));
            return $decode;
        }catch(Exception $e){
            return "unauthorized";
        }
    }
}
