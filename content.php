<center>
    <form action="/formini" method="post" enctype="multipart/form-data">
        <label><p>Podaj nazwę kontrolera:</p><br><input type="text" name="name_control"></label>
        <br>
        <table>
            <tr>
                <th>Wybierz rodzaj kontrolera:</th>
            </tr>
            <tr>
                <td><label><input type="radio" id="type_route" name="type_route" value="0" onclick="showContent(0);">Kod PHP jako funkcja deterministyczna.</label></td>
            </tr>
            <tr>
                <td><label><input type="radio" id="type_route" name="type_route" value="1" onclick="showContent(1);">Kod PHP jako funkcja dynamiczna</label></td>
            </tr>
            <tr>
                <td><label><input type="radio" id="type_route" name="type_route" value="2" onclick="showContent(2);">Kod HTML jako jako podstrona w witrynie</label></td>
            </tr>
            <tr>
                <td><label><input type="radio" id="type_route" name="type_route" value="5" onclick="showContent(5);">Plik obrazu JPEG/PNG/GIF</label></td>
            </tr>
            <tr>
                <td><label><input type="radio" id="type_route" name="type_route" value="6" onclick="showContent(6);">Plik PDF</label></td>
            </tr>
        </table>
        <p><b>Wprowadz (opcjonalnie) opis kontrolera:</b></p>
        <textarea name="nota" rows="20" cols="100"></textarea>
        <div id="main"></div>

    <div id="conthtml" style="display:none;">
        <p><b>Podaj tytuł podstrony: </b></p><input type="text" name="title"></br>
        <p><b>Podaj treść podstrony: </b></p>
        <textarea name="content" rows="20" cols="100">&sol;&ast;Tutaj wprowadż treść posdstrony w HTML.
            Znaczniki &lbrace;&percnt; &percnt;&rbrace; zastąpią treść nowym kontrolerem.&ast;&sol;
        &lsaquo;p&rsaquo;Moja nowa podstrona&lsaquo;&sol;p&rsaquo;</textarea>
    </div>
    <div id="phpdynamic" style="display:none;">
        <p><b>Podaj kod w języku PHP jako funkcję dynamiczną:</b></p>
        <textarea name="content" rows="20" cols="100">&sol;&ast;Tutaj wprowadż treść instrukcji PHP.&ast;&sol;
        namespace App;
        echo PhpStatic::hello($_GET['name']);</textarea>
    </div>
    <div id="phpstatic" style="display:none;">
        <p><b>Podaj kod w języku PHP jako funkcję deterministyczną:</b></p>
        <textarea name="content" rows="20" cols="100">&sol;&ast;Tutaj wprowadż treść instrukcji PHP.&ast;&sol;
        namespace App;
        echo PhpStatic::hello();</textarea>
    </div>
    <div id="pics" style="display:none;">
        <select name="type">
            <option value="jpg">JPEG</option>
            <option value="png">PNG</option>
            <option value="gif">GIF</option>
        </select>
        <table>
            <tr>
                <th>Podaj wysokość obrazu w pikselach: <input type="text" name="height"></th>
            </tr>
            <tr>
                <th>Podaj szerokość obrazu w pikselach: <input type="text" name="width"></th>
            </tr>

            <tr>
                <td>
                    <input type="file" name="obraz">
                </td>

            </tr>
        </table>
    </div>
    <div id="pdf" style="display:none;">
        Kontent dla PDFa.
    </div>
        <input type="submit" value="Utwórz nowy kontroler">
    </form>
    </center>
<script>
    function showContent(type_route){
        document.getElementById('phpstatic').style.display = 'none';
        document.getElementById('phpdynamic').style.display = 'none';
        document.getElementById('conthtml').style.display = 'none';
        document.getElementById('pics').style.display = 'none';
        document.getElementById('pdf').style.display = 'none';
        switch (type_route) {
            case 0:
                document.getElementById('phpstatic').style.display = 'block';
                break;
            case 1:
                document.getElementById('phpdynamic').style.display = 'block';
                break;
            case 2:
                document.getElementById('conthtml').style.display = 'block';
                break;
            case 5:
                document.getElementById('pics').style.display = 'block';
                break;
            case 6:
                document.getElementById('pdf').style.display = 'block';
                break;
        }
    }
</script>