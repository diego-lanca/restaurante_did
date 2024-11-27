document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-remover').forEach(button => {
        button.addEventListener('click', () => {
            const itemNome = button.getAttribute('data-item');
            const quantity = button.getAttribute('quantity');

            if (quantity > 1) {
                fetch('../scripts/remove_quantity.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ item_nome: itemNome })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Recarrega a página
                    } else {
                        alert('Erro ao remover uma unidade.');
                    }
                });
            }
        });
    });
});