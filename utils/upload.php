<?php

$host = 'localhost';
$dbname = 'fotocasa';
$user = 'root';
$pass = '';

$db = new mysqli($host, $user, $pass, $dbname);

if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}

$username = $_POST['username'];

$imagenes = "C:/xampp/htdocs/compracasaframework/utils/uploads/";
$url_imagenes = "http://localhost/compracasaframework/utils/uploads/";
$fichero = $imagenes . basename($_FILES["fileToUpload"]["name"]);
$url_fichero = $url_imagenes . basename($_FILES["fileToUpload"]["name"]);

$compruebaupload = 1;
$imageFileType = strtolower(pathinfo($fichero, PATHINFO_EXTENSION));

if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $compruebaupload = 1;
    } else {
        $compruebaupload = 0;
    }
}

if (file_exists($fichero)) {
    $compruebaupload = 0;
}

if ($_FILES["fileToUpload"]["size"] > 10000000) {
    $compruebaupload = 0;
}

$allowed_extensions = array("jpg", "jpeg", "png", "gif");
if (!in_array($imageFileType, $allowed_extensions)) {
    $compruebaupload = 0;
}

function actualiza_avatar($db, $username, $url_fichero)
{
    $username = $db->real_escape_string($username);
    $avatar = $db->real_escape_string($url_fichero);

    $sql = "UPDATE `users` SET avatar = '$avatar' WHERE `username` = '$username'";
    error_log('Consulta SQL en update_avatar: ' . $sql);
    $stmt = $db->query($sql);
}

if ($compruebaupload == 0) {
    echo "Error en la comprobacion del fichero";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $fichero)) {
        actualiza_avatar($db, $username, $url_fichero);
        echo "Actualizacion correcta";
    } else {
        echo "Error en la actualización del perfil";
    }
}
