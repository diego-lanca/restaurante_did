<?php
session_start();
require_once '../includes/db_connect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Recupera as categorias do banco de dados
$queryCategorias = "SELECT * FROM tb_categoria";
$resultCategorias = mysqli_query($conn, $queryCategorias);

// Recupera os itens do cardápio do banco de dados
$queryItens = "SELECT i.id, i.nome, i.descricao, i.imagem_path, i.preco, c.id as idCategoria, c.nome AS categoria
               FROM tb_itens i
               JOIN tb_categoria c ON i.idCategoria = c.id";
$resultItens = mysqli_query($conn, $queryItens);

$categorias = [];
$itens = [];

// Prepara os dados para as categorias
if ($resultCategorias && mysqli_num_rows($resultCategorias) > 0) {
    while ($row = mysqli_fetch_assoc($resultCategorias)) {
        $categorias[] = $row;
    }
}

// Prepara os dados para os itens
if ($resultItens && mysqli_num_rows($resultItens) > 0) {
    while ($row = mysqli_fetch_assoc($resultItens)) {
        $itens[] = $row;
    }
}

// Simula a categoria selecionada (substitua por $_GET ou $_POST se necessário)
$categoriaSelecionada = isset($_GET['categoria']) ? $_GET['categoria'] : 'todas';

// Filtra os itens conforme a categoria selecionada
if ($categoriaSelecionada === 'todas') {
    $itensFiltrados = $itens; // Exibe todos os itens
} else {
    $itensFiltrados = array_filter($itens, function($item) use ($categoriaSelecionada) {
        return $item['idCategoria'] == $categoriaSelecionada;   
    });
}

include '../templates/cardapio.html';
?>