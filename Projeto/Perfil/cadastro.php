<?php
require_once "../connect.php";
session_start();
if(isset($_SESSION['id_conta'])){
    header('Location: ../Perfil/perfil.php');
    echo json_encode(['status'=>'erro','mensagem'=>'Sessão terminada, redirecionando usuario...']);
    exit;
}
if($_SERVER['REQUEST_METHOD']=='POST'){
    header('Content-Type: application/json');
    $dados = json_decode(file_get_contents('php://input'),true);

    $nome = trim($dados['nome'] ?? '');
    $email = trim($dados['email'] ?? '');
    $senha = trim($dados['senha'] ?? '');

    if(!empty($nome)&&!empty($email)&&!empty($senha)){
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            try{
                $sql = 'SELECT id_conta,nome,email,senha,tipo,data_criacao FROM conta WHERE email = :email';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':email' => $email]);
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount()>0){
                    echo json_encode(['status'=>'erro','mensagem'=>'conta já cadastrada']);
                    exit;
                }else{
                    try{
                        $senha = password_hash($senha,PASSWORD_DEFAULT);
                        $sql = 'INSERT INTO conta(nome,email,senha) VALUES (:nome,:email,:senha)';
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':nome' => $nome,
                                        ':email'=> $email,
                                        ':senha'=> $senha]);

                        $id_conta = $pdo->lastInsertId();
                        $_SESSION['id_conta']= $id_conta;
                        $_SESSION['nome']= $nome;
                        $_SESSION['email']= $email;
                        $_SESSION['tipo'] = $usuario['tipo'];
                        $_SESSION['data_criacao'] = $usuario['data_criacao'];


                        echo json_encode(['status'=>'sucesso','mensagem'=>'Usuario cadastrado com sucesso!']);
                        exit;
                    }catch(PDOException $e){
                        echo json_encode(['status'=>'erro','mensagem'=>'Erro ao inserir dados do usuario '. $e->getMessage()]);
                        exit;
                    }
                }
            }catch(PDOException $e){
                echo json_encode(['status'=>'erro','mensagem'=>'Erro ao verificar email do usuario '. $e->getMessage()]);
                exit;
            }
        }else{
            echo json_encode(['status'=>'erro','mensagem'=>'Email invalido']);
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../style.css"></link>
    <script src="../Perfil/cadastro.js" defer></script>
</head>
<body>
    <header><?php include '../nav.php'?></header>
    <div class="container-cadastro">
        <form id="form-cadastro" method="POST">
        <label for="nome">Nome</label>    
        <input name="nome" id="nome" type="text" required>
        <label for="email">Email</label>    
        <input name="email" id="email" type="email" required>
        <label for="senha">Senha</label>    
        <input name="senha" id="senha" type="password" required>
        <button type="submit">Cadastrar</button>
        <p>Já possui uma conta? <a href="../Perfil/login.php">Login</a></p>
        </form>
    </div>
</body>
</html>