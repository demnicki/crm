<?php

namespace App;

class AddController
    /* Klasa dodająca nowy kontroler.*/
{
    public $_nameControl;
    public $_typeRoute;

    public function __construct($nameControl, $typeRoute, $orLoge, $nota)
    {
        $this->_nameControl = $nameControl;
        $this->_typeRoute = $typeRoute;
        $sqlController = "SELECT * FROM `routing` WHERE `name_control` = '" . $this->_nameControl . "'";
        $obj = new ServicesDatabase;
        $db_handle = $obj->connectDb($sqlController);
        if (mysqli_num_rows($db_handle) > 0) {
            echo 'Podano błędny kontroler. Sprawdż poprawność bazy danych.';
            exit;
        }
        $sqlAdd = "INSERT INTO `routing` (`name_control`, `type_route`, `or_log`, `nota`) VALUES ('" . $nameControl . "', '" . $typeRoute . "', '" . $orLoge . "', '" . $nota . "');";
        $obj = new ServicesDatabase;
        $db_handle = $obj->connectDb($sqlAdd);
    }

    public function phpStatic($content)
    {
        if ($this->_typeRoute == 0) {
            $sql="INSERT INTO `php_static` (`name_control`, `content`) VALUES ('" . $this->_nameControl . "', '" . $content . "');";
            $obj = new ServicesDatabase;
            $db_handle = $obj->connectDb($sql);
        } else {
            return "błędna liczba typu routingu.";
        }

    }

    public function phpDynamic($content)
    {
        if ($this->_typeRoute == 1) {
            $sql="INSERT INTO `php_dynamic` (`name_control`, `content`) VALUES ('" . $this->_nameControl . "', '" . $content . "');";
            $obj = new ServicesDatabase;
            $db_handle = $obj->connectDb($sql);

        } else {
            return "błędna liczba typu routingu.";
        }

    }

    public function html($title, $idTemplate, $content)
    {
        if ($this->_typeRoute == 2) {
            $sql="INSERT INTO `page_html` (`name_control`, `title`, `id_template`, `content`) VALUES ('" . $this->_nameControl . "', '" . $title . "', '" . $idTemplate . "', '" . $content . "');";
            $obj = new ServicesDatabase;
            $db_handle = $obj->connectDb($sql);

        } else {
            return "błędna liczba typu routingu.";
        }
    }

    public function css()
    {
        if ($this->_typeRoute == 3) {

        } else {
            return "błędna liczba typu routingu.";
        }

    }

    public function js()
    {
        if ($this->_typeRoute == 4) {

        } else {
            return "błędna liczba typu routingu.";
        }

    }

    public function pics($type, $height, $width)
    {
        if ($this->_typeRoute == 5) {
            if($type == 'jpg' or $type == 'png' or $type == 'gif') {
                $content = base64_encode(file_get_contents($_FILES['obraz']['tmp_name']));
                $sql = "INSERT INTO `pictures` (`name_control`, `type`, `height`, `width`, `content`) VALUES ('" . $this->_nameControl . "', '".$type."', '".$height."', '".$width."', '" . $content . "');";
            }else{
                return "Błąd składni.";
            }
        } else {
            return "błędna liczba typu routingu.";
        }

    }

    public function pdf()
    {
        if ($this->_typeRoute == 6) {

        } else {
            return "błędna liczba typu routingu.";
        }

    }

    public function mailing()
    {
        if ($this->_typeRoute == 0) {

        } else {
            return "błędna liczba typu routingu.";
        }

    }
}