<?php
namespace App;

class ServicesDatabase
{
    public $_dbHandle;
    public function connectDb($sql){
        $obj = new ServicesJson;
        $this->_dbHandle = mysqli_connect($obj->_dbHost, $obj->_dbUserName, $obj->getPassword(), $obj->_dbName);
        // Check connection
        if (mysqli_connect_errno()) {
            echo "Bład połączenia z bazą danych: " . mysqli_connect_error();
            exit();
        }
        $db_handle = mysqli_query($this->_dbHandle, $sql);
        return $db_handle;
    }
    public function __destruct()
    {
        mysqli_close($this->_dbHandle);
    }
}