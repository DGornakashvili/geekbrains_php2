<?php

namespace App\Classes;

use App\Traits\SingletonTrait;
use \PDO;

class DB
{
    use SingletonTrait;

    protected $pdo;

    protected function __construct()
    {
        $this->pdo = new PDO(DB_DNS, DB_USER, DB_PASS);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function fetchOne($sql)
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute();

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($sql)
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function exec($sql)
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute();
    }
}