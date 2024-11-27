<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_GET['id'])) {
    header('Location: cardapio.php');
    exit;
}

$item_id = $_GET['id'];

$query = "SELECT i.id, i.nome, descricao, preco, idCategoria, i.imagem_path, c.nome as Categoria
    FROM tb_itens i
    JOIN tb_categoria c
    ON c.id = i.idCategoria
    WHERE i.id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $item_id);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se o item existe
if ($result->num_rows === 0) {
    header('Location: cardapio.php');
    exit;
}

$item = $result->fetch_assoc();
$stmt->close();
$conn->close();

include '../templates/detalhes_item.html';
?>