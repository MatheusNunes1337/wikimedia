<h1>Olá</h1>
<div id="root"></div>
<button onclick="carregar()">clique</button>
<script type="text/javascript">
	let r = document.getElementById('root');
	function carregar() {
		fetch('formulario.html'
		)
		.then(response => response.text())
		.then(html => {
			r.innerHTML = html; 		
	 	})
	  	.catch(error => {
	  		console.log(error);
	    }); 
	
	}
</script>