<?php  
	require_once('conecta.php');

	function criarPostagem($conexao,$array){
       try {
            $query = $conexao->prepare("insert into postagens (conteudo, usuario_id, sala_id, nm_midia) values (?, ?, ?, ?)");
            $post = $query->execute($array);
            return $post;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

    function listarPostagens($conexao, $array) {
         try {
        $query = $conexao->prepare("select usuarios.username, usuarios.foto, usuarios.usuario_id, postagens.post_id, postagens.conteudo, postagens.nm_midia, comentarios.conteudo from usuarios JOIN sala_membros USING (usuario_id) JOIN postagens USING (sala_id) JOIN comentarios USING (post_id) where sala_membros.sala_id = ?"); 
        if($query->execute($array)){
            $posts = $query->fetchAll(PDO::FETCH_ASSOC); 
            return $posts;
        }
        else{
            return false;
        }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }
    }

    function buscarPostagem($conexao, $content) {
    	try {
    		$query = $conexao->prepare("select usuarios.username, usuarios.foto, usuarios.usuario_id, postagens.post_id, postagens.conteudo, postagens.nm_midia, comentarios.conteudo from usuarios JOIN sala_membros USING (usuario_id) JOIN postagens USING (sala_id) JOIN comentarios USING (post_id) where postagens.conteudo like '%$content%'");
    		$query->execute();
    		$postagens = $query->fetchAll();
            return $postagens;
    	} catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      } 
    }





?>