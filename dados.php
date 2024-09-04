<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dados Cadastrados</title>
    <link rel="stylesheet" href="dados.css">
</head>
<body>
    <div class="container">
        <?php
        include('db.php');

        $sql = "SELECT id, nome, genero, temporada, episodio, nota
                FROM series
                ORDER BY nome ASC, temporada ASC, episodio ASC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Nome</th>
                        <th>Gênero</th>
                        <th>Temporada</th>
                        <th>Episódio</th>
                        <th>Nota</th>
                        <th>Ações</th>
                    </tr>";

            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['nome']}</td>
                        <td>{$row['genero']}</td>
                        <td>{$row['temporada']}</td>
                        <td>{$row['episodio']}</td>
                        <td>{$row['nota']}</td>
                        <td>
                            <a href='edit.php?id={$row['id']}' class='button small-button'>Editar</a>
                            <a href='delete.php?id={$row['id']}' class='button small-button'>Excluir</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nenhum dado encontrado.</p>";
        }

        $conn->close();
        ?>
        <a href="inicio.html" class="button">Voltar para a Página Inicial</a>
    </div>
</body>
</html>
