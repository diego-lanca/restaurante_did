document.getElementById('finalizarPedidoBtn').addEventListener('click', function(e) {
    e.preventDefault();  // Previne o redirecionamento padrão (se houver um form que pode estar causando isso)

    // Mostrar a mensagem de carregamento
    document.getElementById('loadingMsg').style.display = 'block';
    
    // Esconder o botão enquanto o carregamento está ativo
    document.getElementById('finalizarPedidoBtn').style.display = 'none';
    
    // Criar uma requisição AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../scripts/buy.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Enviar a requisição para o PHP
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Analisar a resposta JSON do PHP
            var response = JSON.parse(xhr.responseText);

            // Esconder a mensagem de carregamento
            document.getElementById('loadingMsg').style.display = 'none';

            // Se o pedido foi finalizado com sucesso
            if (response.success) {
                alert(response.success); // Exibe o alerta de sucesso
                setTimeout(function() {
                    window.location.href = "../pages/pedido_view.php"; // Redireciona para a página de pedidos
                }, 2000); // Aguarda 2 segundos antes de redirecionar
            } else {
                // Caso contrário, exibir mensagem de erro
                alert(response.error); // Exibe o alerta de erro
                document.getElementById('finalizarPedidoBtn').style.display = 'block';
            }
        }
    };

    // Enviar os dados (se necessário)
    xhr.send();
});
