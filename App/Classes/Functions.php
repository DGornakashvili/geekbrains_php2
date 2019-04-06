<?php

namespace App\Classes;


abstract class Functions
{
    /**
     * Ответ на AJAX запрос в формате JSON
     * @param string $type тип ответа
     * @param mixed $data данные ответа
     * @param bool $error если запрос выполнен успешно true, иначе false
     */
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