<?php  
	session_start();
?>
<link rel="stylesheet" type="text/css" href="includes/componentes/estilo.css">
<header>
	<div id="logo">
		<p>Wikimedia</p>
	</div>
	<div class="buscar-sala">
		<label for="buscarSala"></label>
		<input type="text" name="buscarSala" id="buscarSala" placeholder="buscar sala">
		<button>&#8981;</button>
	</div>
	<div class="user-section">
		<div id="user-foto"></div>
		<div id="username"><?php echo $_SESSION['username'];?></div>
		<button id="user-options" onclick="abrirOpcoes()">&#9776;</button>
	</div>
</header>