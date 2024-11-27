<?php
include './includes/db_connect.php';
session_start();

$is_logged_in = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao Restaurante Did</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <h1>Bem-vindo ao Restaurante</h1>
    </header>
    <main>
        <p>Experimente nossas deliciosas receitas e faça seu pedido online!</p>

        <?php if ($is_logged_in): ?>
            <p>Olá, <strong>Usuário</strong>!</p>
            <a href="./pages/cardapio.php" class="btn">Ver Cardápio</a>
            <a href="./pages/logout.php" class="btn">Sair</a>
        <?php else: ?>
            <a href="./pages/login.php" class="btn">Entrar</a>
            <a href="./pages/cadastro.php" class="btn">Cadastrar</a>
        <?php endif; ?>
    </main>

    <?php include './includes/footer.php'; ?>
</body>

</html>