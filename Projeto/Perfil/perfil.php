<?php 
require_once '../connect.php';
session_start();

if(!isset($_SESSION['id_conta'])){
    header('Location: ../Perfil/cadastro.php');
    exit;
}
 if($_SERVER['REQUEST_METHOD']==='POST'){
    header('Content-Type: application/json');
    $dados = json_decode(file_get_contents('php://input'),true);

    $senha= trim($dados['senha'] ?? '');
    $id_conta = $_SESSION['id_conta'];

    if(!empty($senha)){
        try{
            $sql = 'SELECT id_conta,nome,email,senha,tipo,data_criacao FROM conta WHERE id_conta = :id_conta';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id_conta'=>$id_conta]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount()<0){
                echo json_encode(['status'=>'erro','mensagem'=>'usuario não encontrado']);
            }else{
                if(password_verify($senha,$usuario['senha'])){
                    //fazer algo
                }
            }
        }catch(PDOException $e){
            echo json_encode(['status'=>'erro','mensagem'=>'erro ao verificar senha'.$e->getMessage()]);
        }
        
    }


 }


?>



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
        <h3>Olá! <?php echo $_SESSION['nome']?></h1>
        <h3>Informações da conta</h3>
        <button id="btn editar" type="submit">Editar conta</button>
        <div class="modal" role="dialog"></div>
    </main>
</body>
</html>