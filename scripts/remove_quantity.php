<?php
session_start();
require_once '../includes/db_connect.php';

if (isset($_POST['item_nome']) && isset($_SESSION['user_id'])) {
    $item_nome = $_POST['item_nome'];
    $user_id = $_SESSION['user_id'];

    $query = "
        UPDATE tb_itens_pedido ip
        JOIN tb_itens i ON ip.idItem = i.id
        SET ip.quantidade = ip.quantidade - 1
        WHERE i.nome = ? AND ip.idUsuario = ? AND ip.finalizado = 0
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $item_nome, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
    $conn->close();
}
?>
