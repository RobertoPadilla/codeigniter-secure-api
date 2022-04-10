<?php

use App\Models\UserModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getJWTFromRequest($authenticationHeader): string
{
    if (is_null($authenticationHeader)) {
        throw new Exception("Missing or invalid JWT in request", 1);
    }

    return explode(' ', $authenticationHeader)[1];
}

function decodeToken($encodedToken)
{
    $key = Services::getSecretKey();
    return JWT::decode($encodedToken, new Key($key, 'HS256'));
}

function validateUserJWTFromRequest(string $encodedToken)
{
    $decodedToken = decodeToken($encodedToken);
    $userModel = new UserModel();
    $userModel->findUserByEmailAdress($decodedToken->email);
}

function validateAdminJWTFromRequest(string $encodedToken)
{
    $decodedToken = decodeToken($encodedToken);
    $userModel = new UserModel();
    return $userModel->isAdminByEmail($decodedToken->email);
}

function getSignedJWTForUser(string $email): string
{
    $issuedAtTime = time();
    $tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
    $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
    $payload = [
        'email' => $email,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration
    ];

    $jwt = JWT::encode($payload, Services::getSecretKey(), 'HS256');

    return $jwt;
}