<?php

namespace App;

class DirectRouting
/* Klasa sterująca kontrolerami.
 * Usuwająca, edytująca, i dodająca poszczególne typy kontrolerów.
 * */
{
    public $_nameControl;
    public $_typeControl;
    public function __construct($nameControl)
    {
            $this->_nameControl = $nameControl;
            $sqlTypeControl = "SELECT `type_route` FROM `routing` WHERE `name_control` = '".$this->_nameControl."'";
            $obj = new ServicesDatabase;
            $db_handle = $obj->connectDb($sqlTypeControl);
            if (mysqli_num_rows($db_handle) < 1 or mysqli_num_rows($db_handle) > 1){
                echo 'Podano błędny kontroler. Sprawdż poprawność bazy danych.';
                exit;
            }
            while ($row = mysqli_fetch_assoc($db_handle)) {
                $this->_typeControl = $row['type_route'];
            }
    }
    /* Funkcja kasująca kontroler. */
    public function deleteControler(){
        $sqlDelete = "DELETE FROM `routing` WHERE `name_control` = '".$this->_nameControl."'";
        switch ($this->_typeControl){
            case 0:
                $sqlDeleteContent = "DELETE FROM `php_static` WHERE `name_control` = '".$this->_nameControl."'";
                break;
            case 1:
                $sqlDeleteContent = "DELETE FROM `php_dynamic` WHERE `name_control` = '".$this->_nameControl."'";
                break;
            case 2:
                $sqlDeleteContent = "DELETE FROM `page_html` WHERE `name_control` = '".$this->_nameControl."'";
                break;
            case 3:
                $sqlDeleteContent = "DELETE FROM `pictures` WHERE `name_control` = '".$this->_nameControl."'";
                break;
        }
        $obj = new ServicesDatabase;
        $db_handle = $obj->connectDb($sqlDeleteContent);
        $obj = new ServicesDatabase;
        $db_handle = $obj->connectDb($sqlDelete);
        return 'Usunięto kontroler o nazwie '.$this->_nameControl;
    }
    /* Funkcja tworząca nowy kontroler. */
    public function addControler($typeControl,$orLog, $nota, $title, $idTemplate, $content){
        $sqlIsControl = "SELECT `type_route` FROM `routing` WHERE `name_control` = '".$this->_nameControl."'";
        $obj = new ServicesDatabase;
        $db_handle = $obj->connectDb($sqlIsControl);
        if (mysqli_num_rows($db_handle) >= 1) {
            return 'Kontroler o takiej nazwie już istnieje';
        }
        $sqlAddControl = "INSERT INTO `routing` (`name_control`, `type_route`, `or_log`, `nota`) VALUES ('".$this->_nameControl."', '".$typeControl."', ''".$orLog."', '".$nota."')";
        switch ($orLog){
            case 0:
                $sqlAddContent = "INSERT INTO `php_static` (`name_control`, `content`) VALUES ('".$this->_nameControl."', '".$content."')";
                break;
            case 1:
                $sqlAddContent = "INSERT INTO `php_dynamic` (`name_control`, `content`) VALUES ('".$this->_nameControl."', '".$content."')";
                break;
            case 2:
                $sqlAddContent = "INSERT INTO `page_html` (`name_control`, `title`, `id_template`, `content`) VALUES ('".$this->_nameControl."', '".$title."', '".$idTemplate."', '".$content."')";
                break;
            default:
                return 'Błędny typ kontrolera.';
                break;
        }
        $obj = new ServicesDatabase;
        $db_handle = $obj->connectDb($sqlAddControl);
        $obj = new ServicesDatabase;
        $db_handle = $obj->connectDb($sqlAddContent);
        unset($obj);
        return "Pomyślnie utworzono kontroler o nazwie ".$this->_nameControl;

    }
    /* Funkcja tworząca nowy kontroler z obrazem. */
    public function addPicter($typeControl,$orLog, $nota, $height, $width, $nameFile)
    {
        $sqlIsControl = "SELECT `type_route` FROM `routing` WHERE `name_control` = '".$this->_nameControl."'";
        $obj = new ServicesDatabase;
        $db_handle = $obj->connectDb($sqlIsControl);
        if (mysqli_num_rows($db_handle) >= 1) {
            return 'Kontroler o takiej nazwie już istnieje';
        }
        $sqlAddPicter = "INSERT INTO `pictures` (`name_control`, `type`, `height`, `width`, `content`) VALUES ('".$this->_nameControl."', '".$typeControl."', '".$typeControl."', '".$typeControl."', '".$_FILES[$nameFile]['tmp_name']."'";
        $obj = new ServicesDatabase;
        $db_handle = $obj->connectDb($sqlAddPicter);
    }
    /* Funkcja edytująca kontroler. */
    public function editController(){

    }
    /*Funkcja generująca tablicę wszystkich kontrolerów
     * */
    public static function showAllController(){
        $table = '<table>
        <tr>
        <th style="width: 5px">L.p.</th>
        <th style="width: 35px">Nazwa kontrolera</th>
        <th style="width: 30px">Rodzaj kontrolera</th>
        <th style="width: 5px">Czy wymaga zalogowania użytkwnika</th>
        <th style="width: 50px">Opis kontrolera</th>
        <th style="width: 20px">Przycisk edycji</th>
        <th style="width: 20px">Przycis usunięcia</th>
    </tr>';
        $lp = 1;
        $sqlAlleControl = "SELECT * FROM `routing`";
        $obj = new ServicesDatabase;
        $db_handle = $obj->connectDb($sqlAlleControl);
        while ($row = mysqli_fetch_assoc($db_handle)) {
            switch ($row['type_route']){
                case 0:
                    $typeRoute = 'Instrukcja PHP wykonywana deterministycznie';
                    break;
                case 1:
                    $typeRoute = 'Instrukcja PHP wykonywana dynamiczie';
                    break;
                case 2:
                    $typeRoute = 'Podstrona HTML';
                    break;
                case 3:
                    $typeRoute = 'Obraz';
                    break;

            }
            switch ($row['or_log']) {
                case 0:
                    $orLog = 'Nie';
                    break;
                case 1:
                    $orLog = 'Tak!';
                    break;
            }

            $table .= '<tr>
        <td style="width: 5px">'.$lp.'</td>
        <th style="width: 35px">'.$row['name_control'].'</th>
        <td style="width: 30px">'.$typeRoute.'</td>
        <td style="width: 5px">'.$orLog.'</td>
        <td style="width: 50px">'.$row['nota'].'</td>
        <td style="width: 20px">Przycisk edycji</td>
        <td style="width: 20px">Przycis usunięcia</td>
    </tr>';
        $lp++;
        }
        return $table.'</table>';

    }


}