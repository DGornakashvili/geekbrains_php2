<?php

namespace App\Classes;

abstract class Functions
{
	/**
	 * Преобразует данные в формат JSON для ответа на AJAX запрос
	 * @param string $type тип ответа
	 * @param mixed $data данные ответа
	 * @param bool $error ошибка, если запрос выполнен успешно true, иначе false
	 * @return string тип ответа, данные ответа и ошибка в формате JSON
	 */
	public static function ajaxResponse($type, $data, $error = false)
	{
		header('Content-type: application/json');
		return json_encode([
			'error' => $error,
			'type' => $type,
			'data' => $data,
		]);
	}
}