<link rel="stylesheet" type="text/css" href="../../includes/componentes/estilo.css">
<form method="POST" action="../../includes/logica/logica_usuario.php" id="cadastro">
	<div class="cabeçalho">
		<p>Sign up</p>
	</div>
	<div id="campos">
		<div class="campo">
			<input type="text" name="username" id="username" placeholder="username">
			<small>ssssss</small>
		</div>
		<div class="campo">
			<input type="email" name="email" id="email" placeholder="email">
			<small>dddddd</small>
		</div>
		<div class="campo">
			<input type="password" name="senha" id="senha" placeholder="senha">
			<small>ssssss</small>
		</div>
		<div class="campo" style="margin-top: 25px;">
			<button name="cadastrar">Cadastrar</button>
		</div>
	<p id="possuir_conta">
		<a href="login.php">Já possui uma conta?</a>
	</p>
</form>