<?php
class Response
{

    // AKCIJA ZA SLANJE ODGOVORA
    public static function send($status, $data)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
