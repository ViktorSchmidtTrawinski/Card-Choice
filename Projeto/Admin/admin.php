<?php
require_once '../connect.php';
session_start();

if(!isset($_SESSION['tipo']) || $_SESSION['tipo']!=='Admin'){
    header('Content-Type: application/json');
    echo json_encode(['status'=>'erro','mensagem'=>'Acesso negado']);
    exit;
}

if(isset($_GET['action'])&& $_GET['action']=='listar'){
    header('Content-Type: application/json');
    
    try{
        $sql = 'SELECT id_conta,nome,email,tipo,data_criacao FROM conta';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['status'=>'sucesso','usuarios'=>$usuarios]);
        exit;
    }catch(PDOException $e){
        echo json_encode(['status'=>'erro','mensagem'=>'Erro ao buscar usuarios'.$e]);
        exit;
    }
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    header('Content-Type: application/json');
    $dados = json_decode(file_get_contents('php://input'),true);

    $action = $dados['action'] ?? '';
    $id_conta = trim($dados['id_conta'] ?? '');
    $nome = trim($dados['nome'] ?? '');
    $email = trim($dados['email'] ?? '');
    $tipo = trim($dados['tipo'] ?? '');
    $data_criacao = trim($dados['data_criacao'] ?? '');

    if($action == 'excluir'){
        if(!empty($id_conta)){
            $sql = 'DELETE FROM conta WHERE id_conta = :id_conta';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id_conta'=>$id_conta]);
            echo json_encode(['status'=>'sucesso','mensagem'=>'Usuario excluido com sucesso']);
            exit;
        }else{
            echo json_encode(['status'=>'erro','mensagem'=>'Não foi possivel encontrar o usuario para exclusão']);
            exit;
        }
    }else if($action == 'editar'){
            //fazer algo
    }else{
        echo json_encode(['status'=>'erro','mensagem'=>'Erro ao executar ação']);
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="admin.js" defer></script>
    <link rel='stylesheet' href="../style.css"></link>
</head>
<body>
    <header><?php include '../nav.php'?></header>
    <h2>Usuarios cadastrados:<h2>
    <div class="lista-usuarios"></div>
    
</body>
</html>