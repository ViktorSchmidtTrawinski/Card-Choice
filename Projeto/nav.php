<div class="container-nav">
    <nav>
        <a href="../Home/home.php">Home</a>
        <a href="../Perfil/perfil.php">Perfil</a>
        <a href="#">Cards</a>
        <?php
        if(isset($_SESSION['tipo'])){
            if($_SESSION['tipo']=='Admin'){
                echo "<a href='../Admin/admin.php'>Administração</a>";
            }
        }
        ?>
        <a href="../logout.php">Sair</a>
    </nav>
</div>