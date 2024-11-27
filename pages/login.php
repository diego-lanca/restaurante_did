<?php
include '../includes/db_connect.php';
include '../includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Validação dos campos
    if (empty($email) || empty($senha)) {
        $error = "E-mail e senha são obrigatórios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "E-mail inválido.";
    } else {
        // Consulta para verificar o usuário
        $query = "SELECT * FROM tb_usuario WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($senha, $user['senha'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header("Location: cardapio.php");
                exit;
            } else {
                $error = "Senha incorreta.";
            }
        } else {
            $error = "Usuário não encontrado.";
        }
    }
}

include '../templates/login.html';
?>
