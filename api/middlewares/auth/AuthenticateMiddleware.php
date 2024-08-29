<?php

require_once __DIR__ . '/../../../helpers/JwtHandler.php';
require_once __DIR__ . '/../../../helpers/Response.php';

class AuthenticateMiddleware
{
    // PROVJER VAILIDNOSTI JWT TOKENA NA ZAHTJEVU
    public function handle()
    {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            $decoded = JwtHandler::decode($token);
            if ($decoded) {
                return;
            }
        }
        Response::send(401, ['message' => 'Unauthorized']);
        exit();
    }
}
