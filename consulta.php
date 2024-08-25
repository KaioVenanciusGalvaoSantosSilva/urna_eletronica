<?php
// Conecte ao banco de dados
$pdo = new PDO('mysql:host=localhost;dbname=urna_eletronica', 'root', '');

// Obtém o total de votos para candidatos
$query = $pdo->prepare("SELECT * FROM candidatos");
$query->execute();
$candidatos = $query->fetchAll(PDO::FETCH_ASSOC);

// Obtém o total de votos brancos
$query = $pdo->prepare("SELECT COUNT(*) as total FROM votos WHERE voto_tipo = 'branco'");
$query->execute();
$votosBrancos = $query->fetch(PDO::FETCH_ASSOC)['total'];

// Obtém o total de votos nulos
$query = $pdo->prepare("SELECT COUNT(*) as total FROM votos WHERE voto_tipo = 'nulo'");
$query->execute();
$votosNulos = $query->fetch(PDO::FETCH_ASSOC)['total'];

// Calcula o total de votos
$totalVotos = array_sum(array_column($candidatos, 'votos')) + $votosBrancos + $votosNulos;

function calcularPorcentagem($votos, $totalVotos) {
    if ($totalVotos == 0) {
        return 0;
    }
    return round(($votos / $totalVotos) * 100, 2);
}
?>
