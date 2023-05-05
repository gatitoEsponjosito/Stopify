<?php
session_start();
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

if (isset($_POST['usuario'])) {
    $usuario = $_POST['usuario'];
}
else {
    $usuario = "";
}
if (isset($_POST['correo'])) {
    $correo = $_POST['correo'];
}
else {
    $correo = "";
}
if (isset($_POST['contrasenna'])) {
    $contrasenna = $_POST['contrasenna'];
}
else {
    $contrasenna = "";
}
print('
<link rel="stylesheet" type="text/css" href="assets/css/sign-up.css">
<main>
    <section id="brand-image">
        <img src="./assets/img/logo.png.png" alt="">
    </section>
    <section id="sign-up-form">
        <form name="form-sign-up" action="redirect_user.php" method="post" class="form-wrapper">
            <h1 class="login-header">Bienvenido a Stopify.</h1>
            <a href="">
                <button class="btn ph-btn">
                    Continuar con teléfono
                </button>
            </a>
            <div class="divider">
                <div></div>
                <p>or</p>
                <div></div>
            </div>
            <label>Correo.</label>
            <input type="text" name="correo" placeholder="Correo" value="'.$correo.'" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
            <label>Nombre de usuario.</label>
            <input type="text" name="nombre_usuario" placeholder="Username" value="'.$usuario.'" required>
            <label>Contraseña.</label>
            <input type="password" name="contrasenna" placeholder="Contraseña" value="'.$contrasenna.'" required>
            <a href="index.php">Ya tienes una cuenta? Inicia sesión.</a>
            <input type="submit" name="sign-up" value="Registrar" class="sign-up-btn" id="sign-up-btn">');
if (isset($_SESSION['error'])) {
    if ($_SESSION['error'] == "mail_already_registered") {
        print("<p style='color: red';>Ingreso un correo o contraseña invalido.</p>");
        $_SESSION['error'] = "";
    }
}
print("
        </form>
    </section>
</main>
<script src='http://code.jquery.com/jquery-1.11.0.min.js'></script>
<script language='JavaScript' type='text/javascript'>
$(document).ready(function() {
    $('input').keyup(function(event) {
        if (event.which === 13)
        {
            event.preventDefault();
            $('#sign-up-btn').click();
            return false;
        }
    });
});
</script>
<noscript>Sorry, your browser does not support JavaScript!</noscript>
");

/*

print("
<main>
    <section id=\"brand-image\">
        <img src=\"./assets/img/logo.png.png\" alt=\"\">
    </section>
    <section id=\"sign-up-form\">
        <form  action=\"search.php\" method=\"post\" class=\"form-wrapper\">
            <h1 class=\"login-header\">Bienvenido a Stopify.</h1>
            <a href=\"\">
                <button class=\"btn ph-btn\">
                    Continuar con teléfono
                </button>
            </a>
            <div class=\"divider\">
                <div></div>
                <p>or</p>
                <div></div>
            </div>
            <label>Correo.</label>
            <input type=\"text\" name=\"correo\" placeholder=\"Correo\" value=\"$correo\">
            <label>Nombre de usuario.</label>
            <input type=\"text\" name=\"usuario\" placeholder=\"Username\" value=\"$usuario\">
            <label>Contraseña.</label>
            <input type=\"password\" name=\"contrasenna\" placeholder=\"Contraseña\" value=\"$contrasenna\">
            <a href='index.php'>Ya tienes una cuenta? Inicia sesión.</a>
            <input type=\"submit\" value=\"Registrar\" class=\"sign-up-btn\">
        </form>
    </section>
</main>");
$resultado->free();
$mysqli->close();*/