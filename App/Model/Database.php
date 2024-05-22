<?php


class Database {
    private static $pdo = null;
    private static $statement;

    public static function connect() {
        $info = [
            "DB_USER" => "root",
            "DB_PASSWORD" => "123456",
            "DB_DSN" => "mysql:host=localhost;dbname=efm1"
        ];

        if (is_null(self::$pdo)) {
            try {
                self::$pdo = new PDO($info['DB_DSN'], $info['DB_USER'], $info['DB_PASSWORD']);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    public static function query($sql, $binds) {
        static::$statement = static::$pdo->prepare($sql);

        foreach ($binds as $key => $value) {
            static::$statement->bindValue($key, $value);
        }

        return static::$statement->execute();
    }

    public static function rowCount() {
        return static::$statement->rowCount();
    }

    public static function fetch($param) {
        return static::$statement->fetch($param);
    }

    public static function fetchAll($param) {
        return static::$statement->fetchAll($param) ?? null;
    }

    public static function lastInsertId() {
        return static::$pdo->lastInsertId();
    }
}
