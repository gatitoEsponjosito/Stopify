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

$_SESSION['id_usuario'] = -1;
if (isset($_SESSION['correo'])) {
    $correo = $_SESSION['correo'];
}
else {
    $correo = "";
}
if (isset($_SESSION['nombre_usuario'])) {
}
else {
    $_SESSION['nombre_usuario'] = '';
}
if (isset($_SESSION['contrasenna'])) {
    $contrasenna = $_SESSION['contrasenna'];
}
else {
    $contrasenna = "";
}

print('
<link rel="stylesheet" type="text/css" href="assets/css/log-in.css">
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
            <label>Contraseña.</label>
            <input type="password" name="contrasenna" placeholder="Contraseña" value="'.$contrasenna.'" required>
            <a href="sign-up.php">No tienes una cuenta? Registrate.</a>
            <input type="submit" name="log-in" value="Iniciar Sesión" class="sign-up-btn" id="log-in-btn">');
if (isset($_SESSION['error'])) {
    if ($_SESSION['error'] == "invalid_credential") {
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
            $('#log-in-btn').click();
            return false;
        }
    });
});
</script>
<noscript>Sorry, your browser does not support JavaScript!</noscript>
");