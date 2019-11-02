<?php  

	require_once('includes/componentes/header.php');
	require_once('includes/componentes/nav.php');
	require_once('includes/componentes/aside.php');
	require_once('includes/logica/conecta.php');
    require_once('includes/logica/funcoes_sala.php');

    $array = array($_SESSION['sala_id'], $_SESSION['sala_id']); //duas vezes pois preciso do mesmo valor em dois momentos na mesma consulta

?>
<section>
<h1>Gerência de usuários:</h1>
	<?php  
	$usuarios = listarUsuarios($conexao, $array);
	if(empty($usuarios)) {
		?>
		<p>Parece que não há nenhum usuário dentro desta sala.</p>
		<?php 
	} else {
		foreach ($usuarios as $usuario) {
			?>
			<p><?php echo $usuario['username']?></p>
			<button onclick="banirUsuario(event)" id="<?php echo($usuario['usuario_id'])?>">Banir</button>
			<button onclick="tornarAdmin(event)" id="<?php echo($usuario['usuario_id'])?>">Tornar administrador</button>
			<hr>
			<?php  
		}
	}
	?>
</section>
<script src="js/async_funcoes.js"></script>