<form name="editarSala" onsubmit="editaSala()">
	<p>Nome:</p>
		<input type="text" name="nome" required="true"><br>
	<p>Descrição:</p>	
		<input type="text" name="descricao" required="true"><br>
	<p>Nível:</p>
		<select name="nivel">
			<option value="iniciante">iniciante</option>
			<option value="intermediário">intermediário</option>
			<option value="avançado">avançado</option>
			<option value="mestre">mestre</option>
		</select>
	<p>Número máximo de membros:</p>	
		<input type="text" name="membros" required="true"><br>	
	<p>Disciplina:</p>	
		<input type="text" name="disciplina" required="true"><br>
	<p>Conteúdo:</p>	
		<input type="text" name="conteudo" required="true"><br><br>
	<button type="submit">Done</button>
	<button type="submit">Deletar sala</button>		
</form>
<script src="js/async_funcoes.js"></script>
<script type="text/javascript">	
	window.onload = function acharSala() {
		fetch('includes/logica/logica_sala.php?infoSala=true', {
			method: 'GET'
		})
		.then(response => response.json())
		.then(data => {
			if(data.status == 'sucesso') {
				let editarSala = document.getElementsByTagName('form')[0];
				editarSala.nome.value = data.nome;
				editarSala.descricao.value = data.descricao;
				editarSala.nivel.value = data.nivel;
				editarSala.membros.value = data.max_membros;
				editarSala.disciplina.value = data.disciplina;
				editarSala.conteudo.value = data.conteudo;
			
			} else {
				console.log(data.mensagem);
			}
			
		})
		.catch(err => {
			console.error(err);
		})
	}
</script>