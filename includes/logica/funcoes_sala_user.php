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
            $query = $conexao->prepare("select postagens.post_id, postagens.conteudo, postagens.nm_midia, usuarios.usuario_id, usuarios.username, usuarios.foto FROM usuarios LEFT JOIN postagens USING (usuario_id) where postagens.sala_id = ? order by postagens.post_id desc");
            if($query->execute($array)){
                $posts = $query->fetchAll(PDO::FETCH_ASSOC); 
                return $posts;
            }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }
    }

    function listarComentarios($conexao, $array) {
         try {
            $query = $conexao->prepare("select comentarios.conteudo, usuarios.username, usuarios.foto FROM postagens LEFT JOIN comentarios USING (post_id) LEFT JOIN usuarios ON (comentarios.usuario_id = usuarios.usuario_id) where comentarios.conteudo is not null and postagens.post_id = ? order by comentarios.comentario_id asc");
            if($query->execute($array)){
                $posts = $query->fetchAll(PDO::FETCH_ASSOC); 
                return $posts;
            }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }
    }

    function buscarPostagem($conexao, $array, $content) {
    	try {
    		$query = $conexao->prepare("select postagens.post_id, postagens.conteudo, postagens.nm_midia, usuarios.usuario_id, usuarios.username, usuarios.foto FROM usuarios LEFT JOIN postagens USING (usuario_id) where postagens.sala_id = ?  and postagens.conteudo like '%$content%' order by postagens.post_id desc");
    		$query->execute($array);
    		$postagens = $query->fetchAll(PDO::FETCH_ASSOC);
            return $postagens;
    	} catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      } 
    }

    function criarComentario($conexao, $array) {
        try {
            $query = $conexao->prepare("insert into comentarios (conteudo, usuario_id, post_id) values (?, ?, ?)");
            $resultado = $query->execute($array);
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function deletarPostagem($conexao, $array) {
        try {
            $query = $conexao->prepare("delete from postagens where post_id = ?");
            $result = $query->execute($array);
            return $result;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }





?>