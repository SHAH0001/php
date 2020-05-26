<?php

namespace Core;

use App\Config;
use Core\Str;
use Core\Pagination;
use PDO;

abstract class Model
{
    // Переменная хранит число сообщений выводимых на станице
    protected $num = 15;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table;

    protected static function connectionDB()
    {
        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }

    public static function find($id) 
    {
        $instance = new static;

        return is_array($id) ? 
        $instance->getCollectionRecords($id, $instance) : 
        $instance->getRecord($id, $instance);
    }

    protected function getRecord($id, $instance) 
    {
        $tableName = $instance->getTable($instance);

        $db = static::connectionDB();

        $statement = $db->prepare("SELECT * FROM $tableName WHERE `id` = :id");

        $statement->execute(['id' => $id]);

        return $statement->fetch(PDO::FETCH_OBJ);
    }

    protected function getCollectionRecords($ids, $instance) 
    {
        $tableName = $instance->getTable($instance);   
        
        $db = static::connectionDB();

        $identifiers = str_repeat('?,', count($ids) - 1) . '?';

        $statement = $db->prepare("SELECT * FROM $tableName WHERE `id` IN ($identifiers)");

        $statement->execute($ids);
    
        return $instance->getAll($statement);
    }

    protected function getTable($instance)
    {
        if(isset($this->table)) {
            return $this->table;
        }

        return lcfirst(basename(get_class($instance)));
    }

    public static function all()
    {
        $results = [];

        $instance = new static;

        // получение имени таблицы
        $tableName = $instance->getTable($instance);

        // соединение
        $db = static::connectionDB();

        // подготовка
        $statement = $db->prepare("SELECT * FROM $tableName");
        
        // выполнение
        $statement->execute();

        // получение        
        return $instance->getAll($statement);
    }

    public static function where($column, $operator = null, $value = null)
    {
        $instance = new static;

        $tableName = $instance->getTable($instance);

        $db = static::connectionDB();

        if (func_num_args() == 2) {
            list($value, $operator) = [$operator, '='];
        }

        $statement = $db->prepare("SELECT * FROM $tableName WHERE $column $operator '$value'");

        $statement->execute();

        if($statement->rowCount() == 0) {
            return [];
        }

        if($statement->rowCount() > 1) {
            return $instance->getAll($statement);
        }

        return $statement->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Gets all the data from the request
     *
     * @param   PDO instance
     *
     * @return  array    array with data from query
     */
    protected function getAll($statement) 
    {
        $results = [];
        
        foreach($statement->fetchAll(PDO::FETCH_OBJ) as $item) {
            $results[] = $item;   
        }

        return $results;
    }

    public static function getUser($email, $password)
    {
        $instance = new static;

        $tableName = $instance->getTable($instance);

        $db = static::connectionDB();

        $statement = $db->prepare("SELECT * FROM $tableName WHERE email=:email AND password=:password");

        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public static function createUser(array $data)
    {
        $instance = new static;
        
        $tableName = $instance->getTable($instance);   
        
        $db = static::connectionDB();

        $statement = $db->prepare("INSERT INTO $tableName (email, password) VALUES (:email, :password)");

        $statement->execute([
            'email' => $data['email'],
            'password' => $data['password']
        ]);
    }
}