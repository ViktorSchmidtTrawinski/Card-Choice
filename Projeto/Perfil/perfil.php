<?php session_start();?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="../style.css"></link>
</head>
<body>
    <header><?php include '../nav.php';?></header>
    <main>
        <h3>Informações da conta</h3>
        <p>Nome: <?php echo $_SESSION['nome']?></p>
        <p>Email: <?php echo $_SESSION['email']?></p>
        <p>Senha: <?php echo $_SESSION['senha']?></p>
    </main>
</body>
</html>