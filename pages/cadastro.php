<?php
include '../includes/db_connect.php';
include '../includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = sanitize_input($_POST['nome']);
    $email = sanitize_input($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    $query = "INSERT INTO tb_usuario (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $nome, $email, $senha);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Erro ao cadastrar usuário.";
    }
}

include '../templates/cadastro.html';
?>
