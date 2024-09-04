<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Buscar os detalhes da série para edição
    $sql = "SELECT * FROM series WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Coletar dados do formulário
        $nome = $_POST['nome'];
        $genero = $_POST['genero'];
        $temporada = $_POST['temporada'];
        $episodio = $_POST['episodio'];
        $nota = $_POST['nota'];

        // Atualizar a série no banco de dados
        $sql = "UPDATE series SET nome = ?, genero = ?, temporada = ?, episodio = ?, nota = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiiii", $nome, $genero, $temporada, $episodio, $nota, $id);

        if ($stmt->execute()) {
            $message = "Atualizado com sucesso!";
        } else {
            $message = "Erro: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
} else {
    die("ID não fornecido.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Série</title>
    <link rel="stylesheet" href="cadastroseries.css">
</head>
<body>
    <div class="container">
        <?php if (isset($message)) { ?>
            <h1><?php echo $message; ?></h1>
            <a href="dados.php" class="button">Voltar para a lista de dados</a>
        <?php } else { ?>
            <h2>Editar Série</h2>
            <form action="edit.php?id=<?php echo $id; ?>" method="post">
                <label for="nome">Nome do seriado:</label>
                <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($row['nome']); ?>" required>

                <label for="genero">Gênero:</label>
                <input type="text" name="genero" id="genero" value="<?php echo htmlspecialchars($row['genero']); ?>">

                <label for="temporada">Temporada:</label>
                <input type="number" name="temporada" id="temporada" value="<?php echo htmlspecialchars($row['temporada']); ?>" min="1">

                <label for="episodio">Episódio:</label>
                <input type="number" name="episodio" id="episodio" value="<?php echo htmlspecialchars($row['episodio']); ?>" min="1">

                <label for="nota">Nota do episódio:</label>
                <input type="number" name="nota" id="nota" value="<?php echo htmlspecialchars($row['nota']); ?>" min="1" max="10">

                <input type="submit" value="Atualizar">
            </form>
        <?php } ?>
    </div>
</body>
</html>
