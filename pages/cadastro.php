
<?php
// Ativar a exibição de erros
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>


<?php
include '../includes/db_connect.php';
include '../includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = sanitize_input($_POST['nome']);
    $email = sanitize_input($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);
    $cep = sanitize_input($_POST['cep']);
    $rua = sanitize_input($_POST['rua']);
    $numero = sanitize_input($_POST['numero']);
    $bairro = sanitize_input($_POST['bairro']);
    $complemento = sanitize_input($_POST['complemento']);
    $cidade = sanitize_input($_POST['cidade']);
    $estado = sanitize_input($_POST['estado']);

    $query = "INSERT INTO tb_usuario (nome, email, senha, cep, rua, numero, bairro, complemento, cidade, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssss", $nome, $email, $senha, $cep, $rua, $numero, $bairro, $complemento, $cidade, $estado);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Erro ao cadastrar usuário.";
    }
}

include '../templates/cadastro.html';
?>
