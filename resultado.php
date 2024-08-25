<?php include 'consulta.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados da Votação</title>
    <link rel="stylesheet" href="/css/resultado.css">
</head>
<body>
    <div class="container">
        <h1>Resultados da Votação</h1>
        <table>
            <thead>
                <tr>
                    <th>Candidato</th>
                    <th>Partido</th>
                    <th>Foto</th>
                    <th>Votos</th>
                    <th>Porcentagem</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($candidatos as $candidato): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($candidato['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($candidato['partido'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><img src="<?php echo htmlspecialchars($candidato['foto'], ENT_QUOTES, 'UTF-8'); ?>" alt="Foto do Candidato" class="foto-candidato"></td>
                        <td><?php echo $candidato['votos']; ?></td>
                        <td><?php echo calcularPorcentagem($candidato['votos'], $totalVotos); ?>%</td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Votos Brancos</strong></td>
                    <td><?php echo $votosBrancos; ?></td>
                    <td><?php echo calcularPorcentagem($votosBrancos, $totalVotos); ?>%</td>
                </tr>
                <tr>
                    <td colspan="3"><strong>Votos Nulos</strong></td>
                    <td><?php echo $votosNulos; ?></td>
                    <td><?php echo calcularPorcentagem($votosNulos, $totalVotos); ?>%</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
