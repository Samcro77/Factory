<?php

/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 04.03.2016
 * Time: 18:03
 */
class Database
{
    private $_connection;

    private static $_instance;
    private $_host = "localhost";
    private $_username = "root";
    private $_password = "";
    private $_database = "test";

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    private function __construct()
    {
        $this->_connection = new mysqli($this->_host, $this->_username,
            $this->_password, $this->_database);


        if (mysqli_connect_error()) {
            trigger_error("Failed  connect to MySQL: " . mysqli_connect_error(),
                E_USER_ERROR);
        }
    }


    private function __clone()
    {
    }


    public function getConnection()
    {
        return $this->_connection;
    }



}