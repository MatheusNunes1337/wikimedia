<link rel="stylesheet" type="text/css" href="../../includes/componentes/estilo.css">
<body style="background-image: url(../../includes/componentes/imagens/interface/login_background.jpg);">
	<form method="POST" action="../../includes/logica/logica_usuario.php" id="login">
		<div class="cabeçalho">
			<p>Login</p>
		</div>
		<div id="campos">
			<div class="campo">
				<input type="text" name="username" id="username" placeholder="username">
			</div>
			<div class="campo">
				<input type="password" name="senha" id="senha" placeholder="senha">
			</div>
			<div class="campo" style="margin-top: 25px;">
				<button id="logar" name="logar">Entrar</button>
			</div>
		<p id="possuir_conta">
			<a href="cadastro.php">Não possui uma conta ainda?</a>
		</p>
	</form>
</body>