<?php  
	require_once('conecta.php');

	function criarPostagem($conexao,$array){
       try {
            $query = $conexao->prepare("insert into postagens (conteudo, usuario_id, sala_id) values (?, ?, ?)");
            $post = $query->execute($array);
            return $post;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }





?>