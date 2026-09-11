<?php  require "../connect.php"?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../style.css"></link>
</head>

<body>
    <header><?php include '../nav.php'?></header>
    <div class="container-cadastro">
        <form id="form-cadastro" method="POST">
        <label for="nome">Nome</label>    
        <input id="nome" type="text" required>
        <label for="email">Email</label>    
        <input id="email" type="email" required>
        <label for="senha">Senha</label>    
        <input id="senha" type="password" required>
        <button type="submit">Cadastrar</button>
        <p>Já possui uma conta? <a href="#">Login</a></p>
        </form>
    </div>
    
</body>
</html>