<?php
$host = "localhost";
$db_name = "restaurante";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
