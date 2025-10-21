<?php
define('HOST','127.0.0.1');
define('USUARIO','root');
define('SENHA','Joao1308');
define('DB','projeto_individual');

$conexao = mysqli_connect(HOST, USUARIO, SENHA, DB) or die('Não foi possível conectar');

if ($conn->connect_error) {
  die("Falha na conexão: " . $conn->connect_error);
}
$sql = "SELECT nome FROM  produtos Where id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "test: " . $row["nome"]. "<br>";
  }
} else {
  echo "0 results";
}
$conn->close();


?>