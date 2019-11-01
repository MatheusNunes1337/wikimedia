<?php  
	session_start();
	require_once('includes/logica/conecta.php');
    require_once('includes/logica/funcoes_sala.php');
    //require_once('/includes/logica/funcoes_admin.php');
?>
<h1>Bem vindo, essa é a sala de ID: <?php echo $_SESSION['sala_id'];?></h1>
<ul>
	<li><a href="solicitacoes.php">solicitacoes</a></li>
</ul>