<?php
$hostname = 'database-proyecto.cr5eoved3rep.us-east-1.rds.amazonaws.com';
$user = 'admin';
$password = '1Rksg0cv7A01A4tvIgpo';
$database = 'Stopify'; 
$port = 3306;
$mysqli = new mysqli($hostname, $user, $password, $database, $port);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

if (isset($_POST['key-words'])) {
    $key_words = $_POST['key-words'];
}
else {
    $key_words = "";
}

$queryBuscaCancion = "CALL searchCancion ('$key_words')";
$queryBuscaAlbum = "CALL searchAlbum ('$key_words')";

$resultado = $mysqli->query($queryBuscaCancion);

print("
<link rel='stylesheet' href='assets/css/search.css'>
<div id='content'>
    <div id='nav-bar'>
        <ul>
            <li>
                <a href=''> 
                    <img src='./assets/img/icon/home.icon.svg' class='lat-icon' alt=''> Inicio
                </a>
            </li>
            <li>
                <a href=''> 
                    <img src='./assets/img/icon/search-icon.svg' class='lat-icon' alt=''> Buscar
                </a>
            </li>
            <li>
                <a href=''> 
                    <img src='./assets/img/icon/library-icon.svg' class='lat-icon' alt=''> Tu biblioteca
                </a>
            </li>
            <li>
                <a href=''> 
                    <img src='./assets/img/icon/playlist-icon.svg' class='lat-icon' alt=''> Listas
                </a>
            </li>
            <li>
                <a href=''> 
                    <img src='./assets/img/icon/heart-138.svg' class='lat-icon' alt=''> Favoritos
                </a>
            </li>
        </ul>
    </div>
    <div id='app-body'>
        <div class='search-section'>                
            <form action='search.php' method='post'>
                <input type='text' name='key-words' id='input-album' placeholder='Buscar por canción/álbum' value=''.$key_words.''>
                <input type='submit' value='Buscar' id='btn-submit'>
            </form>
        </div>
        <div id='search-display'>
            <div class='search-row'>
                <form action='album.php' method='post' name='redirect' class='redirect'>
                    <input type='hidden' class='post' name='post' value=''>
                    <input type='submit' style='display: none;'>
                </form>
");

while ($row_cancion = $resultado->fetch_assoc()) {
    $mysqli->next_result();
    $resultado_artistas = $mysqli->query ("CALL cancionArtistas ('". $row_cancion["id_cancion"] ."')");
    $artistas = $resultado_artistas->fetch_assoc()["artistas"];
    print("
        <a href='javascript:void(0)' class='tarjeta-data' var='".$row_cancion["id_album"]."'>
            <div class = \"tarjeta\">
                <img src=\"". $row_cancion["port_path"] ."\" alt=\"\">
                <div class=\"tarjeta-descrip\">
                    <h1>". $row_cancion["titulo"] ."</h1>
                    <a href=\"\">$artistas</a>
                </div>
            </div>
        </a>
    ");
}
print("
            </div>
        </div>
    </div>
</div>
<script src='http://code.jquery.com/jquery-1.11.0.min.js'></script>
<script language='JavaScript' type='text/javascript'>
$(document).ready(function(){
    $('.tarjeta-data').click(function() {
        var link = $(this).attr('var');
        $('.post').attr('value',link);
        $('.redirect').submit();
    }); 
});
</script>
<noscript>Sorry, your browser does not support JavaScript!</noscript>
");
$resultado->free();
$mysqli->close();