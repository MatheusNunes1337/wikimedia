<?php  
	session_start();
?>
<link rel="stylesheet" type="text/css" href="includes/componentes/estilo.css">
<header>
	<div id="logo">
		<p>Wikimedia</p>
	</div>
	<div class="buscar-sala">
		<form name="buscar" onsubmit="buscarSala()">
			<label for="search_room"></label>
			<input type="text" name="disciplina" id="search_room" placeholder="buscar sala">
			<button type="submit">&#8981;</button>
		</form>
	</div>
	<div class="user-section">
		<div id="user-foto"></div>
		<div id="username"><?php echo $_SESSION['username'];?></div>
		<button id="user-options" onclick="abrirOpcoes()">&#9776;</button>
	</div>
</header>