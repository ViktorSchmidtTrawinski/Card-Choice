<?php
require_once '../connect.php';
session_start();

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
?>



<!DOCTYPE html>
<html lang="en">
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
    <div class="container-usuarios"></div>
    
</body>
</html>