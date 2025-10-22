document.addEventListener("DOMContentLoaded", function() {
  const btnBuscar = document.getElementById("btnBuscar");
  const campoBusca = document.getElementById("campoBusca");
  const tabela = document.getElementById("tabela-produtos");
  const btnCadastrar = document.getElementById("btnCadastrar");

  // 🔍 BUSCAR PRODUTO (HTML)
  function buscarProdutos(termo = "") {
    fetch(`../php/buscar_produto.php?termo=${encodeURIComponent(termo)}`)
      .then(res => res.text()) // <-- importante: resposta em HTML
      .then(data => {
        tabela.innerHTML = data;
      })
      .catch(err => {
        tabela.innerHTML = "<tr><td colspan='7'>Erro ao buscar produtos.</td></tr>";
        console.error(err);
      });
  }

  // Executa busca ao clicar
  btnBuscar.addEventListener("click", () => {
    const termo = campoBusca.value.trim();
    buscarProdutos(termo);
  });

  // 💾 CADASTRAR PRODUTO (JSON)
  btnCadastrar.addEventListener("click", () => {
    const produto = {
      codigo_loja: document.getElementById("codigoLoja").value,
      codigo_barras: document.getElementById("codigoBarras").value,
      ncm: document.getElementById("ncm").value,
      valor_venda: parseFloat(document.getElementById("valorVenda").value) || 0,
      nome: document.getElementById("nomeProduto").value,
      qtd_estoque: parseInt(document.getElementById("qtdEstoque").value) || 0,
      tipo: document.getElementById("tipoProduto").value,
      marca: document.getElementById("marcaProduto").value,
      categoria: document.getElementById("categoriaProduto").value
    };

    if (produto.nome.trim() === "") {
      alert("Informe o nome do produto.");
      return;
    }

    fetch("../php/cadastrar_produto.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(produto)
    })
      .then(res => res.json())
      .then(data => {
        alert(data.mensagem);
        if (data.status === "ok") {
          // Limpa os campos
          document.querySelectorAll(".form-cadastro input").forEach(i => i.value = "");
          // Atualiza lista de produtos após cadastrar
          buscarProdutos();
        }
      })
      .catch(err => {
        alert("Erro ao cadastrar produto.");
        console.error(err);
      });
  });

  // Carrega lista inicial
  buscarProdutos();
});
