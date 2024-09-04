<?php
include('db.php');

$showConfirmation = false;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Buscar os detalhes da série para confirmação
    $sql = "SELECT nome FROM series WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome = $row['nome'];
    } else {
        die("Série não encontrada.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])) {
        // Executar a exclusão
        $sql = "DELETE FROM series WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $showConfirmation = true;
        } else {
            echo "<p>Erro ao deletar série: " . $conn->error . "</p>";
        }
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Exclusão</title>
    <link rel="stylesheet" href="dados.css">
</head>
<body>
    <div class="container">
        <?php if ($showConfirmation): ?>
            <h2>Série Deletada com Sucesso!</h2>
            <a href="dados.php" class="button">Voltar para a Lista de Dados</a>
        <?php else: ?>
            <h2>Confirmar Exclusão</h2>
            <p>Você tem certeza que deseja deletar a série: <strong><?php echo htmlspecialchars($nome); ?></strong>?</p>
            <form action="delete.php?id=<?php echo $id; ?>" method="post">
                <input type="submit" name="confirmar" value="Deletar" class="button">
                <a href="dados.php" class="button">Cancelar</a>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
