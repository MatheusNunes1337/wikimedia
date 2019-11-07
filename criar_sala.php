
<form method="POST" action="includes/logica/logica_sala.php">
	<p>Nome:</p>
		<input type="text" name="sala_nome" required="true"><br>
	<p>Descrição:</p>	
		<input type="text" name="sala_descricao" required="true"><br>
	<p>Nível:</p>
		<select name="sala_nivel">
			<option value="iniciante">iniciante</option>
			<option value="intermediário">intermediário</option>
			<option value="avançado">avançado</option>
			<option value="mestre">mestre</option>
		</select>
	<p>Número máximo de membros:</p>	
		<input type="text" name="sala_membros" required="true"><br>	
	<p>Disciplina:</p>	
		<input type="text" name="sala_disciplina" required="true"><br>
	<p>Conteúdo:</p>	
		<input type="text" name="sala_conteudo" required="true"><br><br>
	<button type="submit" name="criar_sala">Criar sala</button>
</form>