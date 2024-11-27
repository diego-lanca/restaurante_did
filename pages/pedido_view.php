<?php
// Ativar a exibição de erros
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include('../includes/db_connect.php');
include('../includes/functions.php');

$user_id = $_SESSION['user_id'];  

$query = "
    SELECT i.nome AS item_nome, ip.quantidade, ip.preco, (ip.quantidade * ip.preco) AS total_item
    FROM tb_itens_pedido ip
    JOIN tb_itens i ON ip.idItem = i.id
    WHERE ip.idUsuario = ? AND ip.finalizado = 0
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$itens_pedido = [];
while ($row = $result->fetch_assoc()) {
    $itens_pedido[] = $row;
}

$stmt->close();
$conn->close();

// Calcular o total do pedido
$total_pedido = 0;
foreach ($itens_pedido as $item) {
    $total_pedido += $item['total_item'];
}

include '../templates/pedido.html';
?>