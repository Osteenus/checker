<?php

namespace App\components;
use PDO;

/**
 * Класс Db
 * Компонент для работы с базой данных
 */
class Db
{
    /**
     * Устанавливает соединение с базой данных
     * @return PDO <p>Объект класса PDO для работы с БД</p>
     */
    public static function getConnection():PDO
    {
        // Получаем параметры подключения из файла
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);

        try {
            // Устанавливаем соединение
            $dsn = "pgsql:host={$params['host']};dbname={$params['dbname']}";
            // Задаем кодировку
            // $db->exec("set names utf8");

            return new PDO(
                $dsn,
                $params['user'],
                $params['password'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (\PDOException $e) {
            die($e->getMessage());
        }

    }

}
