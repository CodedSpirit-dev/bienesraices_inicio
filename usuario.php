<?php
//Importar conexion
require 'includes/config/database.php';
$db = conectarDB();
//Crear email y pass
$email = "correo@correo.com";
$password = "123456";

$passwordHash = password_hash($password, PASSWORD_DEFAULT); //Password hash SIEMPRE usa 60 caracteres

//Query para crear el usuario
$query = " INSERT INTO usuarios (email, password) VALUES ( '$email', '$passwordHash' );";

//echo $query;

//exit;

//Agregar a base de datos

mysqli_query($db, $query);
