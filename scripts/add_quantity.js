document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".btn-adicionar").forEach((button) => {
    button.addEventListener("click", () => {
      const itemNome = button.getAttribute("data-item");

      fetch("../scripts/add_quantity.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ item_nome: itemNome }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            location.reload(); // Recarrega a página
          } else {
            alert("Erro ao adicionar uma unidade.");
          }
        });
    });
  });
});
