<?php
session_start();
session_unset();
session_destroy();

header('Location: ../Projeto/Perfil/cadastro.php');

?>