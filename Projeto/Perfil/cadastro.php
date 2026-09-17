<?php
require_once "../connect.php";
session_start();

if(isset($_SESSION['id_conta'])){
    header('Location: ../Perfil/perfil.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    header('Content-Type: application/json');
    $dados = json_decode(file_get_contents('php://input'), true);

    $nome = trim($dados['nome'] ?? '');
    $email = trim($dados['email'] ?? '');
    $senha = trim($dados['senha'] ?? '');

    if(!empty($nome) && !empty($email) && !empty($senha)){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            try {
                $sql = 'SELECT id_conta FROM conta WHERE email = :email';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':email' => $email]);

                if($stmt->rowCount() > 0){
                    echo json_encode(['status' => 'erro', 'mensagem' => 'Conta já cadastrada']);
                    exit;
                } else {
                    try {
                        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                        $sql = 'INSERT INTO conta (nome, email, senha) VALUES (:nome, :email, :senha)';
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([
                            ':nome'  => $nome,
                            ':email' => $email,
                            ':senha' => $senhaHash
                        ]);

                        $id_conta = $pdo->lastInsertId();
                        $_SESSION['id_conta'] = $id_conta;
                        $_SESSION['nome'] = $nome;
                        $_SESSION['email'] = $email;
                        $_SESSION['tipo'] = 'Usuario'; 
                        $_SESSION['data_criacao'] = date('Y-m-d H:i:s');

                        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Usuário cadastrado com sucesso!']);
                        exit;
                    } catch(PDOException $e){
                        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao inserir dados: ' . $e->getMessage()]);
                        exit;
                    }
                }
            } catch(PDOException $e){
                echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao verificar e-mail: ' . $e->getMessage()]);
                exit;
            }
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'E-mail inválido']);
            exit;
        }
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Preencha todos os campos']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../style.css">
    <script src="../Perfil/cadastro.js" defer></script>
</head>
<body>
    <header><?php include '../nav.php'; ?></header>
    <div class="form-area">
        <form id="form-box" class="form-box" method="POST">
            <label for="nome">Nome</label>    
            <input name="nome" id="nome" type="text" required>
            
            <label for="email">Email</label>    
            <input name="email" id="email" type="email" required>
            
            <label for="senha">Senha</label>    
            <input name="senha" id="senha" type="password" required>
            
            <button type="submit" class="btn btn-editar">Cadastrar</button>
            <p>Já possui uma conta? <a href="../Perfil/login.php">Login</a></p>
        </form>
    </div>
</body>
</html>