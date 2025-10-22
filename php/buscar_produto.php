<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

// Configuração do banco
$host = "localhost";
$user = "root";  // altere se necessário
$pass = "";      // senha do MySQL
$dbname = "projeto_individual"; // ✅ novo banco

$conn = new mysqli($host, $user, $pass, $dbname);

// Verifica conexão
if ($conn->connect_error) {
  die("Erro de conexão: " . $conn->connect_error);
}

// Recebe o termo da busca (via GET)
$termo = isset($_GET['termo']) ? trim($_GET['termo']) : '';

if ($termo !== '') {
  // Prepara consulta com LIKE para buscar pelo nome
  $stmt = $conn->prepare("
    SELECT 
      id,
      codigo_loja,
      codigo_barras,
      ncm,
      valor_venda,
      nome,
      qtd_estoque,
      tipo,
      marca,
      categoria
    FROM produto
    WHERE nome LIKE ?
    ORDER BY nome ASC
  ");

  $like = "%" . $termo . "%";
  $stmt->bind_param("s", $like);
  $stmt->execute();
  $result = $stmt->get_result();

  // Retorna resultados formatados em HTML (para inserir direto no <tbody>)
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . htmlspecialchars($row['codigo_loja']) . "</td>";
      echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
      echo "<td>" . htmlspecialchars($row['ncm']) . "</td>";
      echo "<td>" . htmlspecialchars($row['qtd_estoque']) . "</td>";
      echo "<td>" . htmlspecialchars($row['tipo']) . "</td>";
      echo "<td>R$ " . number_format($row['valor_venda'], 2, ',', '.') . "</td>";
      echo "<td>
              <button class='btn btn-sm btn-warning'>Editar</button>
              <button class='btn btn-sm btn-danger'>Excluir</button>
            </td>";
      echo "</tr>";
    }
  } else {
    echo "<tr><td colspan='7'>Nenhum produto encontrado.</td></tr>";
  }

  $stmt->close();
} else {
  echo "<tr><td colspan='7'>Digite algo para buscar.</td></tr>";
}

$conn->close();
?>
