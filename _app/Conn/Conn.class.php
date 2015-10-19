<?php


/**
 * Conn.class [CONNECTION]
 * Abstract class used for database connection. Singleton default.
 * Returns a PDO object through getConn(); static method.
 * @copyright (c) 2015, Arthur F. D. Leon HandsOn Consultoria
 */
abstract class Conn {
    private static $Host = HOST;
    private static $User = USER;
    private static $Pass = PASS;
    private static $Dbsa = DBSA;
    
    /**
     * @var PDO
     */
    private static $Connect = null;
    
    /**
     * Connects to the database using Singleton.
     * Returns a PDO object.
     */
    private static function ConnectDB() {
        try {
            if(self::$Connect == null):
                //dsn define qual o DB a ser usado. No caso estamos usando o MySQL.
                $dsn = 'mysql:host='.self::$Host.';dbname='.  self::$Dbsa;
                $options = [ PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
                self::$Connect = new PDO($dsn, self::$User, self::$Pass, $options);
            endif;
        } catch (PDOException $e) {
            PHPError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            die;
        }
        self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$Connect;
    }
    
    /**
     * Returns a PDO Singleton object
     */
    protected static function getConn() {
        return self::ConnectDB();
    }
}
