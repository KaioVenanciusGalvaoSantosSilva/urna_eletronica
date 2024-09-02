<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de RA</title>
    <link rel="stylesheet" href="/css/verifstyle.css">
</head>
<body>
    <div class="container">
        <h1>Digite seu RA para Votação</h1>
        <form method="POST" action="verificar_ra.php">
            <label for="ra">RA:</label>
            <input type="number" id="ra" name="ra" required maxlength="20">
            <button type="submit">Acessar Urna</button>
        </form>
    </div>
</body>
</html>

<?php
// Iniciar a sessão
session_start();

// Destruir todos os dados associados à sessão
$_SESSION = array(); // Limpar todos os dados da sessão

// Se usar cookies de sessão, exclua o cookie de sessão
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
              $params["path"], $params["domain"], 
              $params["secure"], $params["httponly"]);
}

// Destruir a sessão
session_destroy();

exit;
?>


