document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".add-to-cart");

    buttons.forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Previne recarregar a página
            
            const itemId = this.getAttribute("data-id");

            fetch('../scripts/add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `item_id=${itemId}`,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                    } else {
                        alert(`Erro: ${data.message}`);
                    }
                })
                .catch(error => {
                    alert('Erro ao adicionar o item ao pedido.');
                    console.error('Erro:', error);
                });
        });
    });
});
