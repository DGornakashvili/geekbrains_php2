<?php

namespace App\Classes;

use App\Traits\SingletonTrait;
use \PDO;

/**
 * Class DB
 */
class DB
{
	use SingletonTrait;

	protected $pdo;

	protected function __construct()
	{
		$this->pdo = new PDO(DB_DNS, DB_USER, DB_PASS);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->pdo->exec('SET NAMES utf8');
	}

	/**
	 * @param $sql
	 * @return array
	 */
	public function fetchOne($sql): array
	{
		$sth = $this->pdo->prepare($sql);
		$sth->execute();

		return $sth->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * @param $sql
	 * @return array
	 */
	public function fetchAll($sql): array
	{
		$sth = $this->pdo->prepare($sql);
		$sth->execute();

		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * @param $sql
	 * @return bool
	 */
	public function exec($sql)
	{
		$sth = $this->pdo->prepare($sql);
		return $sth->execute();
	}

	/**
	 * Получить id последней вставленной строки
	 * @return int
	 */
	public function lastInsertId()
	{
		return $this->pdo->lastInsertId();
	}
}