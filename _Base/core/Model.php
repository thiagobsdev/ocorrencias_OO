<?php

namespace core;

use \core\Database;
use \ClanCats\Hydrahon\Builder;
use \ClanCats\Hydrahon\Query\Sql\FetchableInterface;
use ClanCats\Hydrahon\Query\Sql\Insert;

class Model
{

    protected static $_h;

    public function __construct()
    {
        self::_checkH();
    }

    public static function _checkH()
    {
        if (self::$_h == null) {
            $connection = Database::getInstance();
            self::$_h = new Builder('mysql', function ($query, $queryString, $queryParameters) use ($connection) {
                $statement = $connection->prepare($queryString);
                $statement->execute($queryParameters);

                if ($query instanceof FetchableInterface) {
                    return $statement->fetchAll(\PDO::FETCH_ASSOC);
                }
                // Esse código irá retornar o último id inserido no banco de dados quando a conexão executar um insert
                if ($query instanceof Insert) {
                    return $connection->lastInsertId();
                }

                return $statement;
            });
        }

        self::$_h = self::$_h->table(self::getTableName());
    }

    public static function getTableName()
    {
        $className = explode('\\', get_called_class());
        $className = end($className);
        return strtolower($className) . 's';
    }

    public static function select($fields = [])
    {
        self::_checkH();
        return self::$_h->select($fields);
    }

    public static function insert($fields = [])
    {
        self::_checkH();
        return self::$_h->insert($fields);
    }

    public static function update($fields = [])
    {
        self::_checkH();
        return self::$_h->update($fields);
    }

    public static function delete()
    {
        self::_checkH();
        return self::$_h->delete();
    }
}
