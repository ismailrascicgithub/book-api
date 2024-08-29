<?php
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

// POMOCNA KLASA ZA RAD SA JWT TOKENIMA
class JwtHandler
{
    private static $secret_key;
    private static $alg = 'HS256';

    public static function init()
    {
        self::$secret_key = JWT_SECRET_KEY;
    }

    // AKCIJA ZA ENKRIPTOVANJE PODATAKA ODNOSNO GENERISANJE SAMOG TOKENA 
    public static function encode($data)
    {
        if (!isset(self::$secret_key)) {
            self::init();
        }
        return JWT::encode($data, self::$secret_key, self::$alg);
    }

    // AKCIJA ZA DEKRIPTOVANJE PODATAKA ONDOSNO PROVJERU TOKENA
    public static function decode($token)
    {
        if (!isset(self::$secret_key)) {
            self::init();
        }
        try {
            $decoded = JWT::decode($token, new Key(self::$secret_key, self::$alg));
            return (array) $decoded;
        } catch (Exception $e) {
            return null;
        }
    }
}
