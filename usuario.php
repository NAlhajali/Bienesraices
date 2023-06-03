<?php 

//Imprtar la conexcion
require 'includes/config/databases.php';
$db = conectarDB();

// crer email y password
$email =  "correo@correo.com";
$password = "123456";

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

var_dump($passwordHash);
//Query para crear el usuario 
$query = " INSERT INTO usuarios (email, password) VALUES ( '{$email}', '{$passwordHash}'); ";

// echo $query;


// Agregar a la base de datos 
mysqli_query($db, $query);