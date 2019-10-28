<style type="text/css">
	h1 {
		color: red;
	}

</style>
<h1>Olá</h1>
<div id="root"></div>
<button onclick="carregar()">clique</button>
<script type="text/javascript">
	let r = document.getElementById('root');
	function carregar() {
		fetch('html/criar_sala.html'
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