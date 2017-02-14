<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Processor
{
    public static function insert( $table, array $data ){

        $count = 1;
        $fields = '';
        $values = '';

        foreach ( $data as $index => $value ){
            $fields .= substr( $index, 1 );
            $values .= $index;
            if ($count < count( $data ) ){
                $fields .= ', ';
                $values .= ', ';
            }
            $count++;
        }

//        return Database::connect();

        if ( gettype( Database::connect() ) !== 'string' ){

            $query = "INSERT INTO $table ($fields) VALUES ($values)";
            $stmt = Database::connect()->prepare( $query );


            if ( $stmt->execute( $data ) ){
                return true;
            } else if ( $stmt->errorInfo()[0] == 23000 ){
                return 'Could not save data!';
            } else {
                return $stmt->errorInfo();
            }

        } else {

            return Database::connect();
        }


    }

    public static function select( $table ){

        if ( gettype( Database::connect() ) !== 'string' ){

            $stmt = Database::connect()->prepare("SELECT * FROM $table" );

            if ( $stmt->execute() ){
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $stmt->errorInfo();
            }
        } else {

            return Database::connect();
        }
    }

    public static function delete( string $user_name ){
        if ( gettype( Database::connect() ) !== 'string' ){
            $stmt = Database::connect()->prepare('DELETE FROM users WHERE username=:username');
            $stmt->bindParam('username', $user_name );

            if ( $stmt->execute() ){
                return true;
            } else {
                return $stmt->errorInfo();
            }
        } else {
            return Database::connect();
        }
    }

    public static function update( string $user_name, string $actions ){
        if ( gettype( Database::connect() ) !== 'string' ){
            $stmt = Database::connect()->prepare('UPDATE users SET actions=:actions WHERE username=:username');
            $stmt->bindParam('actions', $actions );
            $stmt->bindParam('username', $user_name );

            if ( $stmt->execute() ){
                return true;
            } else {
                return $stmt->errorInfo();
            }
        }
    }

}