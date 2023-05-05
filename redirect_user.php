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
print_r($_POST);
#Procesos compartidos entre Inicio de sesión y registro de usuario
$_SESSION['correo'] = $_POST['correo'];
$_SESSION['contrasenna'] = $_POST['contrasenna'];

#Inicio de sesión
if (isset($_POST['log-in'])) {
    $resultado = $mysqli->query(
        "SELECT id
        FROM usuario
        WHERE correo = '".$_SESSION['correo']."'
        AND contrasenna = '".$_SESSION["contrasenna"]."'"
    );
    if (mysqli_num_rows($resultado) > 0) {
        $_SESSION["id"] = $resultado->fetch_assoc()['id'];
        header('Location: search.php');
    }
    else {
        $_SESSION['contrasenna'] = "";
        $_SESSION['error'] = "invalid_credential";
        header('Location: index.php');
    }
}
#Registro de usuario
if (isset($_POST['sign-up'])) {
    $_SESSION['nombre_usuario'] = $_POST['nombre_usuario'];
    $resultado = $mysqli->query(
        "SELECT id
        FROM usuario
        WHERE correo = '".$_SESSION['correo']."'
    ");
    if (mysqli_num_rows($resultado) > 0) {
        $_SESSION['contrasenna'] = "";
        $_SESSION['error'] = "mail_already_registered";
        header('Location: sign-up.php');
    }
    else {
        $mysqli->query(
            "INSERT INTO usuario(nombre_usuario, correo, contrasenna)
            VALUES('".$_SESSION['nombre_usuario']."', '".$_SESSION['correo']."', '".$_SESSION['contrasenna']."')");
        header('Location: search.php');
    }
}