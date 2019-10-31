<?php
	
	require_once('includes/componentes/header.php');
	require_once('includes/componentes/nav.php');
	require_once('includes/componentes/aside.php');
	require_once('includes/logica/conecta.php');
    require_once('includes/logica/funcoes_sala.php');
 

    $usuario_id = $_SESSION['id'];
    $array = array($usuario_id);

?>
<section>
	<h1>Minhas salas:</h1>
	<?php  
		$salas = listarSalas($conexao, $array);
		if(empty($salas)) {
			?>
			<p>Parece que você ainda não entrou em nenhuma sala.</p>
			<?php 
		} else {
			foreach ($salas as $sala) {
				?>
				<h2><?php echo $sala['nome']?></h2>
				<p><?php echo $sala['descricao']?></p>
				<form action="includes/logica/logica_sala.php" method="GET">
					<input type="hidden" name="sala_id" value="<?php echo($sala['sala_id'])?>">
					<button type="submit" name="entrar_sala">entrar</button>
				</form>
				<hr>
				<?php  
			}
		}
	?>
</section>
<script src="js/async_funcoes.js"></script>
