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

// Consultar datos con MySQLi
#leer entrada
#if (isset($_POST['id_usuario']))
if (isset($_POST['post'])) {
    $id = $_POST['post'];
}
else {
    $id = -1;
}
if (isset($_POST['id-cancion'])) {
    $id_cancion = $_POST['id-cancion'];
}
else {
    $id_cancion = -1;
}

#Get titulo, album port
$resultado = $mysqli->query("
    SELECT album.titulo as titulo, album.port_img as path 
    FROM album WHERE album.id = '$id'"
    );
if (mysqli_num_rows($resultado) > 0) {
    $album_data = $resultado->fetch_assoc();
    $titulo = $album_data["titulo"];
    $port_path = $album_data["path"];
}
else {
    $titulo = "NO ENCONTRADO";
    $port_path = "assets/img/album_portrait/not_found.png";
}
$resultado->close();

#Get artistas
$resultado = $mysqli->query("CALL albumArtistas('$id')");
if (mysqli_num_rows($resultado) > 0) {
    $artistas = $resultado->fetch_assoc()["artistas"];
}
else {
    $artistas = "DESCONOCIDO";
}
$resultado->close();
$mysqli->next_result();

print("
<link rel='stylesheet' type='text/css' href='assets/css/album.css'>
<div id='content'>
        <div id='nav-bar'>
            <ul>
                <li>
                    <a href=''> 
                        <img src='./assets/img/icon/home.icon.svg' class='lat-icon' alt=''> Inicio
                    </a>
                </li>
                <li>
                    <a href='./search.php'> 
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
                    <input type='text' name='post' id='input-album' placeholder='Buscar por canción/álbum'>
                    <input type='submit' value='Buscar' id='btn-submit'>
                </form>
            </div>
            <div id='alb-display'>
            <div id='alb-header'>
                <img class='alb-port' src='$port_path' alt='#'>
                <div id='alb-info'>
                    <div>Album</div>
                    <div class='titulo'>". $titulo ."</div>
                    <div class='alb-art'>". $artistas ."</div>
                </div>
            </div>
            <div id='rep-btn-bar'>
                <input type='image' class='icon-m' src='./assets/img/icon/play-icon.svg' />
                <input type='image' class='icon-s' src='./assets/img/icon/fav-icon.svg' />
                <input type='image' class='icon-s' src='./assets/img/icon/add-to-list.svg' />
            </div>

            <table id='tabla-con-estilo'>
            <tr>
                <th>#</td>
                <th>Titulo</td>
                <th>Artista/s</td>
                <th>Duracion</td>
            </tr>
");

$resultado = $mysqli->query("CALL albumCntTbl ('$id')");

while ($rows = $resultado->fetch_assoc()) {
    if ($rows["id"] == $id_cancion) {
        print("
            <tr class='rcancion' estado='1' orden='". $rows["orden"] ."' id='". $rows["id"]  ."' audio_path=\"assets/audio/mp3/". $rows["audio_path"] ."\">
                <td class='orden'>▶</td>
                <td>". $rows["titulo"]  ."</td>
                <td>". $rows["artista"] ."</td>
                <td>". $rows["min"] .":". str_pad($rows["seg"], 2, '0', STR_PAD_LEFT) . "</td>
            </tr>");
    }
    else {
        print("
            <tr class='rcancion' estado='0' orden='". $rows["orden"] ."' id='". $rows["id"]  ."' audio_path=\"assets/audio/mp3/". $rows["audio_path"] ."\">
                <td class='orden'>". $rows["orden"]   ."</td>
                <td>". $rows["titulo"]  ."</td>
                <td>". $rows["artista"] ."</td>
                <td>". $rows["min"] .":". str_pad($rows["seg"], 2, '0', STR_PAD_LEFT) . "</td>
            </tr>");
    }
}
print("
            </table>
        </div>
    </div>
</div>
<audio id='reproductor' activo='-'>
<source src='assets/audio/mp3/Appetite For Destruction/01 - Welcome To The Jungle.mp3' type='audio/mpeg'>
Your browser does not support the audio element.
</audio>
<script src='http://code.jquery.com/jquery-1.11.0.min.js'></script>
<script language='JavaScript' type='text/javascript'>
$(document).ready(function(){
    $('.rcancion').click(function() {
        if ($(this).attr('estado') == '0') {
            var id_activo = $('#reproductor').attr('activo');
            if (id_activo != '-') {
                var prev = document.getElementById(id_activo);
                prev.setAttribute('estado', '0');
                prev.getElementsByClassName('orden')[0].innerText = prev.getAttribute('orden');
                $('#' + id_activo).css('background-color', 'transparent');
            }
            $(this).attr('estado', '1');
            $(this).css('background-color', '#808080');
            var ord = $('#' + $(this).attr('id')).children('.orden');
            ord.text('▶');
            ord.css('font-size', '14');
            $('#reproductor').attr('src', $(this).attr('audio_path'));
            $('#reproductor').attr('activo', $(this).attr('id'));
            var cancion = document.getElementById('reproductor');
            cancion.play();
        }
        else {
            $(this).attr('estado', '0');
            $(this).css('background-color', 'transparent');
            var ord = $('#' + $(this).attr('id')).children('.orden');
            ord.text($(this).attr('orden'));
            var cancion = document.getElementById('reproductor');
            cancion.pause();
            cancion.currentTime = 0;
        }
    });
});
</script>
<noscript>Sorry, your browser does not support JavaScript!</noscript>
");

$resultado->free();
$mysqli->close();
?>