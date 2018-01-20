<?php


namespace Service;


abstract class DbManager
{
    protected static $pdo;

    public function __construct()
    {
        if (!self::$pdo) {
            self::$pdo = new \PDO('mysql:host=db;dbname=test;charset=utf8', 'root', 'root');
            self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
    }
}