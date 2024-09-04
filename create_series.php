<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nome = $_POST['nome'];
    $genero = $_POST['genero'];
    $temporada = $_POST['temporada'];
    $episodio = $_POST['episodio'];
    $nota = $_POST['nota'];


    $sql = "INSERT INTO series (nome, genero, temporada, episodio, nota)
            VALUES (?, ?, ?, ?, ?)";

   
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $nome, $genero, $temporada, $episodio, $nota);

    
    if ($stmt->execute()) {
        echo "<p></p>";
    } else {
        echo "<p>Erro: " . $stmt->error . "</p>";
    }

    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <link rel="stylesheet" href="cadastroseries.css">
</head>
<body>
    <div class="container">
        <h1>Adicionado com sucesso!</h1>
        <p><?php echo isset($message) ? $message : ''; ?></p>
        <a href="cadastroseries.html" class="button">Cadastrar Nova Série</a>
        <a href="inicio.html" class="button">Voltar para a Página Inicial</a>
    </div>
</body>
</html>