<?php
// Conecte ao banco de dados
$pdo = new PDO('mysql:host=localhost;dbname=urna_eletronica', 'root', '');

// Recebe o número do candidato
$numero = isset($_POST['numero']) ? $_POST['numero'] : '';

// Verifica se o número já existe
$query = $pdo->prepare("SELECT COUNT(*) as total FROM candidatos WHERE numero = ?");
$query->execute([$numero]);
$total = $query->fetch(PDO::FETCH_ASSOC)['total'];

if ($total > 0) {
    echo 'exists';
} else {
    echo 'not_exists';
}
?>
