<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Configuração do banco
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "projeto_individual"; // ✅ banco correto

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
  die(json_encode(["status" => "erro", "mensagem" => "Falha na conexão: " . $conn->connect_error]));
}

// Lê o corpo JSON
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!$data) {
  echo json_encode([
    "status" => "erro",
    "mensagem" => "Nenhum dado recebido",
    "debug" => $raw // apenas para diagnóstico temporário
  ]);
  exit;
}

$codigo_loja   = $data["codigo_loja"] ?? '';
$codigo_barras = $data["codigo_barras"] ?? '';
$ncm           = $data["ncm"] ?? '';
$valor_venda   = $data["valor_venda"] ?? 0;
$nome          = $data["nome"] ?? '';
$qtd_estoque   = $data["qtd_estoque"] ?? 0;
$tipo          = $data["tipo"] ?? '';
$marca         = $data["marca"] ?? '';
$categoria     = $data["categoria"] ?? '';

$stmt = $conn->prepare("
  INSERT INTO produto
  (codigo_loja, codigo_barras, ncm, valor_venda, nome, qtd_estoque, tipo, marca, categoria)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
  echo json_encode([
    "status" => "erro",
    "mensagem" => "Erro ao preparar SQL: " . $conn->error
  ]);
  exit;
}

$stmt->bind_param("sssdsisss",
  $codigo_loja,
  $codigo_barras,
  $ncm,
  $valor_venda,
  $nome,
  $qtd_estoque,
  $tipo,
  $marca,
  $categoria
);

if ($stmt->execute()) {
  echo json_encode(["status" => "ok", "mensagem" => "Produto cadastrado com sucesso!"]);
} else {
  echo json_encode([
    "status" => "erro",
    "mensagem" => "Erro ao cadastrar produto: " . $stmt->error
  ]);
}

$stmt->close();
$conn->close();
?>
