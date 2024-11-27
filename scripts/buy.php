<?php
session_start();
require_once '../includes/db_connect.php';  // Certifique-se de que o caminho esteja correto

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Usuário não está logado."]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Atualizar status de todos os itens do pedido para 'finalizado'
$query = "UPDATE tb_itens_pedido SET finalizado = 1 WHERE idUsuario = ? AND finalizado = 0";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo json_encode(["success" => "Pedido finalizado com sucesso!"]);
} else {
    echo json_encode(["error" => "Erro ao finalizar o pedido."]);
}

$stmt->close();
$conn->close();
?>
