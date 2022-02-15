<?php

namespace App;
use DirectAdressClients as DAC;

class ServicesRouting
    /*
 * Autor: A. J. Demnicki <adamdemnicki@gmail.com>
 * Klasa sterująca całym routingiem adresów.
 * */
{
    public $_nameControl = 'home';
    public function __construct()
    {
        $sqlControllers = 'SELECT `name_control`, `type_route`, `or_log` FROM `routing`';
        $pages = 'SELECT `name_control`, `id_template`, `title`, `content` FROM `page_html`';
        $sqlTemplates = 'SELECT `id`, `head`, `foot` FROM `templates`';
        $phpStatic = 'SELECT `name_control`, `content` FROM `php_static`';
        $phpDynamic = 'SELECT `name_control`, `content` FROM `php_dynamic`';
        if (isset($GLOBALS['controllers']) and isset($GLOBALS['templates'])){

        }else{
            $obj = new ServicesDatabase;
            $db_handle = $obj->connectDb($sqlTemplates);
            $GLOBALS['templates'] = [];
            while ($row = mysqli_fetch_assoc($db_handle)) {
                $GLOBALS['templates'] += [$row['id'] => [$row['head'], $row['foot']]];
            };
            $obj = new ServicesDatabase;
            $db_handle = $obj->connectDb($pages);
            $GLOBALS['pages'] = [];
            while ($row = mysqli_fetch_assoc($db_handle)) {
                $GLOBALS['pages'] += [$row['name_control'] => [$row['id_template'], $row['title'], $row['content']]];
            };
            $obj = new ServicesDatabase;
            $db_handle = $obj->connectDb($sqlControllers);
            $GLOBALS['controllers'] = [];
            while ($row = mysqli_fetch_assoc($db_handle)) {
                $GLOBALS['controllers'] += [$row['name_control'] => [$row['or_log'], $row['type_route']]];
            };
            $obj = new ServicesDatabase;
            $db_handle = $obj->connectDb($phpDynamic);
            $GLOBALS['phpDynamic'] = [];
            while ($row = mysqli_fetch_assoc($db_handle)) {
                $GLOBALS['phpDynamic'] += [$row['name_control'] => $row['content']];
            };
            $obj = new ServicesDatabase;
            $db_handle = $obj->connectDb($phpStatic);
            $GLOBALS['phpStatic'] = [];
            while ($row = mysqli_fetch_assoc($db_handle)) {
                $GLOBALS['phpStatic'] += [$row['name_control'] => $row['content']];
            };
            unset($obj);
        }
    }
    /* Funkcja inicjująca routing po wskazanym adresie. */
    public function routing(){
        $separatorGet = explode('?', $_SERVER['REQUEST_URI']);
        $urlPost = explode('/', $separatorGet[0]);
        $nameControl = $urlPost[1];
        if (isset ($urlPost[2])){
            $nameSecendControl =  $urlPost[2];
        }else{
            $nameSecendControl =  '';
        };
        for ($i=2; $i <count($urlPost); $i++){
            $_SESSION['urlGet'][$i-2] = $urlPost[$i];
        }
        switch ($nameControl){
            case '':
                echo $this->type('home');
                exit;
            case '_reset':
                echo ServicesJson::RefrashResultDynamicPhp();
                exit;
            case '_php':
                if(isset($GLOBALS['phpStatic'][$nameSecendControl])){
                    eval($GLOBALS['phpStatic'][$nameSecendControl]);
                    exit;
                }else if(isset($GLOBALS['phpDynamic'][$nameSecendControl])){
                    eval($GLOBALS['phpDynamic'][$nameSecendControl]);
                    exit;
                }else{
                    echo 'Błędny kontroler';
                    exit;
                }
            case '_pics':
                echo $this->picsRender($nameSecendControl);
                exit;
            default:
                If (isset($GLOBALS['controllers'][$nameControl])){
                    echo $this->type($nameControl);
                    exit;
                }else{
                    echo $this->type('er404');
                    exit;
                }


        }
    }
    /*  Funkcja sprawdza jaki jest typ kontrolera.
     * 0 - funkcja PHP statyczna.
     * 1 - funkcja PHP dynamiczna.
     * 2 - kod HTML.
     * 3 - renderowaie obrazu do kodu HTML.
     *
     * */
    public function type($nameControl){
        if (isset($GLOBALS['controllers'][$nameControl][1])) {
            $typeController = $GLOBALS['controllers'][$nameControl][1];
            switch ($typeController) {
                case 0:
                    return $this->phpStatic($nameControl);
                    break;
                case 1:
                    return $this->phpDynamic($nameControl);
                    break;
                case 2:
                    return $this->render($nameControl);
                    break;
                case 3:
                    return $this->picsHtml($nameControl);
                    break;

            }
        }else{
            return 'Błędny kontroler. Sprawdź bazę danych.';
        }

    }
    /* Funkcja renderująca treść HTML. */
    public function render($nameControl){
        $idTample = $GLOBALS['pages'][$nameControl][0];
        $htmlContent = '<html><head><title>'.$GLOBALS['pages'][$nameControl][1].'</title>'.$GLOBALS['templates'][$idTample][0].'</head></body>';
        If (isset ($GLOBALS['pages'][$nameControl][2])){
            $htmlContent .= $GLOBALS['pages'][$nameControl][2];
        }
        preg_match_all('/\{\%([A-Za-z0-9 ]+?)\%\}/', $htmlContent, $htmlTargetPage, PREG_OFFSET_CAPTURE);
        $arrController = [];
        for ($i = 0; $i < count($htmlTargetPage[1]); $i++){
            $arrController[$i] = trim($htmlTargetPage[1][$i][0]);
            if(isset($GLOBALS['controllers'][$arrController[$i]])){
                $typeController =  $GLOBALS['controllers'][$arrController[$i]][1];
                switch ($typeController) {
                    case 0:
                        $htmlRender = $this->phpStatic($arrController[$i]);
                        break;
                    case 1:
                        $htmlRender = $this->phpDynamic($arrController[$i]);
                        break;
                    case 2:
                        $htmlRender = $this->htmlRender($arrController[$i]);
                        break;
                    case 3:
                        $htmlRender = $this->picsHtml($arrController[$i]);
                        break;

                }
            }else{
                $htmlRender = 'Instrukcja HTML zawiera błędny kontroler.';
            }
            $htmlContent = str_replace($htmlTargetPage[0][$i][0], $htmlRender, $htmlContent);
        }
        return $htmlContent.$GLOBALS['templates'][$idTample][1].'</body></html>';
    }
    /* Powtórne renderwanie  treści HTML. Jeśli pojawiły się znaczniki {% . %} */
    public function htmlRender($nameControl){
        return $GLOBALS['pages'][$nameControl][2];
    }
    /* Funkcja renderująca kod PHP. Jako statyczny. */
    public function phpStatic($nameControl){
        $arrResult = ServicesJson::catchResultDynamicPhp();
            return $arrResult[$nameControl];
        }
    /* Funkcja renderująca kod PHP. Jako dynamiczny przyisany do sesji użytkownika */
    public function phpDynamic($nameControl){
        $arrResult = ServicesJson::catchResultDynamicPhp();
        return file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/_php/'.$nameControl);
    }
    /* Funkcja kod obsługi obrazu w HTML */
    public function picsHtml($nameControl){
        $pictures = "SELECT `type`, `height`, `width`FROM `pictures` WHERE `name_control` = '".$nameControl."'";

        $obj = new ServicesDatabase;
        $db_handle = $obj->connectDb($pictures);
        if (mysqli_num_rows($db_handle) < 1 or mysqli_num_rows($db_handle) > 1){
            return 'Nie ma takiego obrazu.';
        }
        while ($row = mysqli_fetch_assoc($db_handle)) {
            // $type = $row['type'];
            $height = $row['height'];
            $width = $row['width'];
        };
        return '<img height="'.$height.'" width="'.$width.'" src="_pics/'.$nameControl.'" />';
    }
    /* Funkcja renderująca obrazy w HTML pobrane z bazy danych. */
    public function picsRender($nameControl){
        $pictures = "SELECT `content` FROM `pictures` WHERE `name_control` = '".$nameControl."'";

        $obj = new ServicesDatabase;
            $db_handle = $obj->connectDb($pictures);
            if (mysqli_num_rows($db_handle) < 1 or mysqli_num_rows($db_handle) > 1){
                return 'Nie ma takiego obrazu.';
            }
            while ($row = mysqli_fetch_assoc($db_handle)) {
               $content = $row['content'];
            };
            return $content;
    }
    /* Funkcja */
}