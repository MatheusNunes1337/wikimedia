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
<nav id="sala-menu">
	<ul>
		<li><a href="#">Página inicial</a></li>
		<li><button onclick="criarSala()">Criar sala</button></li>
	</ul>
</nav>
<section>
	content
</section>
<aside>
	direita
</aside>
<script type="text/javascript">

	let container = document.getElementsByTagName('section')[0];

	function criarSala() {
	fetch('html/criar_sala.html')	
	.then(response => response.text())
	.then(html => {
		container.innerHTML = html; 		
 	})
  	.catch(error => {
  		console.log(error);
    }); 
}

</script>
