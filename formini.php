<?php
namespace App;
switch ($_POST['type_route']){
    case 0:
        $obj = new AddController($_POST['name_control'], $_POST['type_route'], 0, $_POST['nota']);
        $obj->phpStatic($_POST['content']);
        break;
    case 1:
        $obj = new AddController($_POST['name_control'], $_POST['type_route'],  0, $_POST['nota']);
        $obj->phpDynamic($_POST['content']);
        break;
    case 2:
        $obj = new AddController($_POST['name_control'], $_POST['type_route'], 0, $_POST['nota']);
        $obj->html($_POST['title'], 2, $_POST['content']);
        break;
    case 5:
        $obj = new AddController($_POST['name_control'], $_POST['type_route'],  0, $_POST['nota']);
        $obj->pics($_POST['type'], $_POST['height'], $_POST['width']);
        break;
}
echo "Chura. Udało się utworzyć nowy kontroler."
?>
<a href="/control">Edytowanie kontrolerów</a>
<a href="/addini">Dodaj nowy kontroler</a>
