<?php

require_once __DIR__ . '/../../../helpers/JwtHandler.php';
require_once __DIR__ . '/../../../helpers/Response.php';
class AuthController
{
    // GENERISANJE JWT TOKENA
    public function getToken()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $payload = [
                'user_id' => 1,
                'role' => 'user',
                'iat' => time(),
                'exp' => time() + (60 * 60)
            ];

            $token = JwtHandler::encode($payload);
            Response::send(200, ['token' => $token]);
        } else {
            Response::send(405, ['message' => 'Method Not Allowed']);
        }
    }
}
