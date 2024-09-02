<?php
session_start();

// Verificar se o usuário está logado e se ainda não votou
if (!isset($_SESSION['user_id'])) {
    // Usuário não está logado, redirecionar para a página de login
    header("Location: /");
    exit;
}

// Conectar ao banco de dados
try {
    $pdo = new PDO('mysql:host=localhost;dbname=urna_eletronica', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar se o usuário já votou
    $stmt = $pdo->prepare("SELECT votou FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    

    if ($user && $user['votou']) {
        // Usuário já votou, redirecionar para a página de RA
        header("Location: /");
        exit;
    }
    
} catch (PDOException $e) {
    echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urna Eletrônica</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="urna-container">
        <div class="tela">
            <div id="display">
                <div id="info-candidato">
                    <p id="numero-candidato"></p>
                    <p id="nome-candidato"></p>
                    <p id="partido-candidato"></p>
                    <!-- Adicione a imagem ao seu HTML -->
                </div>
                <img id="foto-candidato" src="" alt="Foto do Candidato">
                <img id="imagem-fim" src="img/fim.png"/>
            </div>
        </div>
        <div class="teclado">
            <div class="numeros">
                <button class="numero" data-num="1">1</button>
                <button class="numero" data-num="2">2</button>
                <button class="numero" data-num="3">3</button>
                <button class="numero" data-num="4">4</button>
                <button class="numero" data-num="5">5</button>
                <button class="numero" data-num="6">6</button>
                <button class="numero" data-num="7">7</button>
                <button class="numero" data-num="8">8</button>
                <button class="numero" data-num="9">9</button>
                <div></div> <!-- Espaço vazio para alinhamento -->
                <button class="numero" data-num="0">0</button>
                <audio id="somClick" src="/mp3/click.mp3" preload="auto"></audio>
            </div>
            <div class="acoes">
                <button id="branco">BRANCO</button>
                <button id="corrigir">CORRIGIR</button>
                <button id="confirmar">CONFIRMAR</button>
                <audio id="somConfirma" src="/mp3/som.mp3" preload="auto"></audio>
            </div>
            <div id="mensagem"></div>
        </div>
    </div>
    <script>
        // Passa o user_id do PHP para o JavaScript
        const userId = "<?php echo $_SESSION['user_id']; ?>";
    </script>
    <script src="/js/scripts.js"></script>
</body>
</html>
