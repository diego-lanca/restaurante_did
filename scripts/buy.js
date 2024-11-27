document.getElementById('finalizarPedidoBtn').addEventListener('click', function(e) {
    e.preventDefault();  // Previne o redirecionamento padrão (se houver um form que pode estar causando isso)

    document.getElementById('loadingMsg').style.display = 'block';
    
    document.getElementById('finalizarPedidoBtn').style.display = 'none';
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../scripts/buy.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);

            document.getElementById('loadingMsg').style.display = 'none';

            if (response.success) {
                alert(response.success);
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
