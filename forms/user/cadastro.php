<link rel="stylesheet" type="text/css" href="../../includes/componentes/estilo.css">
<body style="background-image: url(../../includes/componentes/imagens/interface/login_background.jpg);">
	<form method="POST" action="../../includes/logica/logica_usuario.php" id="cadastro" name="cadastro">
		<div class="cabeçalho">
			<p>Cadastro</p>
		</div>
		<div id="campos">
			<div class="campo">
				<input type="text" name="username" id="username" placeholder="username" onfocusout="verificaUsuario(event)" required="true" pattern=".{6,12}">
				<small>matheus nunes</small>
			</div>
			<div class="campo">
				<input type="email" name="email" id="email" placeholder="email" onfocusout="verificaEmail(event)" required="true">
				<small>matheus nunes</small>
			</div>
			<div class="campo">
				<input type="password" name="senha" id="senha" placeholder="senha" onfocusout="verificaSenha(event)" required="true" pattern=".{6,12}">
				<small>matheus nunes</small>
			</div>
			<div class="campo" style="margin-top: 25px;">
				<button name="cadastrar">Cadastrar</button>
			</div>
		<p id="possuir_conta">
			<a href="login.php">Já possui uma conta?</a>
		</p>
	</form>
	<script src="../../js/async_funcoes.js"></script>
</body>