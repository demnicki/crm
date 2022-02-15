<?php

namespace App;
class ServicesJson
    /*
     * Autor: A. J. Demnicki <adamdemnicki@gmail.com>
     * Klasa do obsługi hurtowni danych JSON.
     * */
{
    public $_dbUserName;
    public $_dbPort = 3306;
    private $_dbUserPassword = '';
    public $_dbName;
    public $_dbHost = 'localhost';
    public function __construct(){
        $fileString = file_get_contents("controllers.json");
        $controllersJson = json_decode($fileString, true);
        $connectDb = $controllersJson['connectDb'];
        $this->_dbHost = $connectDb['host'];
        $this->_dbPort = $connectDb['port'];
        $this->_dbUserName = $connectDb['userName'];
        $this->_dbUserPassword = $connectDb['password'];
        $this->_dbName = $connectDb['nameDb'];

    }
    public function getPassword(){
        return $this->_dbUserPassword;
    }
    public static function catchResultDynamicPhp(){
        $fileString = file_get_contents("resultphp.json");
        return json_decode($fileString, true);
    }
    public static function RefrashResultDynamicPhp(){
        $phpStatic = 'SELECT `name_control`, `content` FROM `php_static`';
        $arrControllers = [];
        $obj = new ServicesDatabase;
        $db_handle = $obj->connectDb($phpStatic);
        try {
        while ($row = mysqli_fetch_assoc($db_handle)) {
            $arrControllers += [$row['name_control'] => file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/_php/'.$row['name_control'])];
        };}catch (Exception $e){
            return 'Błędna liczba kontrolerów';

        }
        $fp = fopen("resultphp.json", "w");
        fputs($fp, json_encode($arrControllers));
        fclose($fp);
        return 'Wynik funkcji statycznych został odswieżony...!';
    }

}