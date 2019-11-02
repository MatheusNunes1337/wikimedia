<?php  
	session_start();
	require_once('includes/logica/conecta.php');
    require_once('includes/logica/funcoes_sala.php');
    //require_once('/includes/logica/funcoes_admin.php');
?>
<h1>Bem vindo, essa é a sala de ID: <?php echo $_SESSION['sala_id'];?></h1>
<ul>
	<li><a href="solicitacoes.php">solicitacoes</a></li>
	<li><a href="gerenciar_usuarios.php">Gerenciar usuários</a></li>
	<li><a href="configurar_sala.php">Configurar sala</a></li>
</ul>