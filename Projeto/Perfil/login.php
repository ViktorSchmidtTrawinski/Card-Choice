<?php
require_once "../connect.php";
session_start();

if($_SERVER['REQUEST_METHOD']=='POST'){
    header('Content-Type: application/json');
    $dados = json_decode(file_get_contents('php://input'),true);
    
    $email = trim($dados['email'] ?? '');
    $senha = trim($dados['senha'] ?? '');

    if(!empty($email)&&!empty($senha)){
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            try{
                $sql = 'SELECT id_conta,nome,email,senha,tipo,data_criacao FROM conta WHERE email = :email';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':email' => $email]);
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount()==0){
                    echo json_encode(['status'=>'erro','mensagem'=>'email ou senha incorretos']);
                    exit;
                }else{
                    if($usuario && password_verify($senha,$usuario['senha'])){
                        $_SESSION['id_conta'] = $usuario['id_conta'];
                        $_SESSION['nome'] = $usuario['nome'];
                        $_SESSION['email'] = $usuario['email'];
                        $_SESSION['tipo'] = $usuario['tipo'];
                        $_SESSION['data_criacao'] = $usuario['data_criacao'];

                        echo json_encode(['status'=>'sucesso','mensagem'=>'Usuario logado com sucesso']);
                        exit;
                    }else{
                        echo json_encode(['status'=>'erro','mensagem'=>'Usuario não encontrado']);
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
    }else{
        echo json_encode(['status'=>'erro','mensagem'=>'campos vazios']);
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
    <script src="../Perfil/login.js" defer></script>
</head>
<body>
    <header><?php include '../nav.php'?></header>
    <div class="form-area">
        <form id="form-box" class="form-box" method="POST">
        <label for="email">Email</label>    
        <input name="email" id="email" type="email" required>
        <label for="senha">Senha</label>    
        <input name="senha" id="senha" type="password" required>
        <button type="submit" class="btn btn-editar">Login</button><br>
        <p>Ainda não possui uma conta? <a href="../Perfil/cadastro.php">Cadastrar</a></p>
        </form>
    </div>
</body>
</html>