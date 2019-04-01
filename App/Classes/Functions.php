<?php

namespace App\Classes;


abstract class Functions
{
    public static function ajaxResponse($type, $data, $error = false)
    {
        header('Content-type: application/json');
        echo json_encode([
            'error' => $error,
            'type' => $type,
            'data' => $data,
        ]);
    }
}