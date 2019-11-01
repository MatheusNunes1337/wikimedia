<?php  

	require_once('includes/componentes/header.php');
	require_once('includes/componentes/nav.php');
	require_once('includes/componentes/aside.php');
	require_once('includes/logica/conecta.php');
    require_once('includes/logica/funcoes_sala.php');

    $array = array($_SESSION['sala_id']);

?>
<section>
<h1>Solicitacoes da sala:</h1>
	<?php  
	$solicitacoes = listarSolicitacoes($conexao, $array);
	if(empty($solicitacoes)) {
		?>
		<p>Parece que ninguém solicitou para entrar nesta sala ainda.</p>
		<?php 
	} else {
		foreach ($solicitacoes as $solicitacao) {
			?>
			<p><?php echo $solicitacao['username']?></p>
			<button onclick="aceitarSolicitacao(event)" id="<?php echo($solicitacao['usuario_id'])?>">Aceitar</button>
			<button onclick="negarSolicitacao(event)" id="<?php echo($solicitacao['usuario_id'])?>">Negar</button>
			<hr>
			<?php  
		}
	}
	?>
</section>
<script src="js/async_funcoes.js"></script>