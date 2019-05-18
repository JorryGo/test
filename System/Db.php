<?php

namespace System;

use PDO;


/**
 * Class Db, for simple using PDO
 * @package System
 */
class Db {

    private static $connection = null;

    private const CONNECTION_CONFIG = [
        'host'     => 'localhost',
        'dbName'   => 'test',
        'user'     => 'root',
        'password' => '123123',
        'charset'  => 'utf8mb4'
    ];

    /**
     * @param string $query A sql string
     * @param array $prepare
     * @return array
     */
    public static function select(string $query, array $prepare = []) : array
    {
        $statement = self::getConnection()->prepare($query);

        $statement->execute($prepare);

        return $statement->fetchAll();
    }

    /**
     * @param string $table Table which uses for insert values
     * @param array $values Values in assoc array. [nameOfColumn => value]
     * @return bool
     */
    public static function insert(string $table, array $values) : bool
    {
        $prepared = self::prepareInsertValues($values);

        $statement = self::getConnection()->prepare('insert into ' . $table
            . ' (' . $prepared['keys'] . ') VALUES ' . $prepared['values']);

        return $statement->execute($prepared['data']);
    }

    /**
     * Returns PDO connection object
     * @return PDO
     */
    private static function getConnection() : PDO
    {
        if (self::$connection) {
            return self::$connection;
        }

        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', ...[
            self::CONNECTION_CONFIG['host'],
            self::CONNECTION_CONFIG['dbName'],
            self::CONNECTION_CONFIG['charset'],
    ]);
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        return self::$connection = (new PDO(
            $dsn,
            self::CONNECTION_CONFIG['user'],
            self::CONNECTION_CONFIG['password'],
            $opt
        ));
    }

    /**
     * Prepares values for safe inserting
     * @param array $values
     * @return array
     */
    private static function prepareInsertValues(array $values) : array
    {
        $result = ['values' => '', 'keys' => [], 'data' => []];

        $getSafeKeys = function (string $key) {
            return preg_replace('/\'|"/i', '', $key);
        };

        $result['keys'] = array_map($getSafeKeys, array_keys($values));

        $valsStr = array_fill(0, count($result['keys']), '?');
        $valsStr = implode(', ', $valsStr);

        $result['values'] = '(' . $valsStr . ')';
        $result['data'] = array_values($values);

        $result['keys'] = implode(', ', $result['keys']);

        return $result;
    }

}