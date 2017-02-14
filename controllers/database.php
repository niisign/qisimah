<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class Database
{
    public static function connect()
    {
        try{

            return new PDO('mysql:host=160.153.16.64;dbname=qisimah;charset=utf8', 'qisimah', 'icuni4cu2');

        } catch ( PDOException $e ){

            if ( $e->getCode() === 1049 ){
                return 'Sorry, the specified database does not exist!';
            } else {
                return $e->getMessage();
            }

        }
    }

}
