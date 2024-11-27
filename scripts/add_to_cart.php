<?php
session_start();
require_once '../includes/db_connect.php';

// Configurações de cabeçalho
header('Content-Type: application/json');

// Captura o ID do item e a quantidade enviados pelo formulário
if (!isset($_POST['item_id']) || !isset($_POST['quantidade']) || !isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Dados insuficientes para processar o pedido.']);
    exit();
}

$item_id = intval($_POST['item_id']); // Validação básica do ID do item
$quantidade = intval($_POST['quantidade']); // Captura a quantidade enviada
$user_id = $_SESSION['user_id']; // ID do usuário logado

if ($quantidade <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Quantidade inválida.']);
    exit();
}

// Verifica se o item já está no pedido
$querySelect = "
    SELECT idItem, quantidade
    FROM tb_itens_pedido
    WHERE idItem = ? AND idUsuario = ? AND finalizado = 0
";
$stmt = $conn->prepare($querySelect);
$stmt->bind_param("ii", $item_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Atualiza a quantidade se o item já existir no pedido
    $row = $result->fetch_assoc();
    $nova_quantidade = $row['quantidade'] + $quantidade;

    $update_query = "
        UPDATE tb_itens_pedido
        SET quantidade = ?
        WHERE idItem = ? AND idUsuario = ? AND finalizado = 0
    ";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("iii", $nova_quantidade, $item_id, $user_id);
    if ($update_stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Quantidade do item atualizada com sucesso.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar a quantidade do item.']);
    }
    $update_stmt->close();
} else {
    // Adiciona o item ao pedido se não existir
    $insert_query = "
        INSERT INTO tb_itens_pedido (idUsuario, idItem, quantidade, preco, finalizado)
        SELECT ?, id, ?, preco, FALSE FROM tb_itens WHERE id = ?";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param('iii', $user_id, $quantidade, $item_id);

    if ($insert_stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Item adicionado ao pedido com sucesso.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao adicionar o item ao pedido.']);
    }
    $insert_stmt->close();
}

$conn->close();


header('Location: ../pages/pedido_view.php');
?>
