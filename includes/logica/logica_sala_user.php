<?php  
	require_once('conecta.php');
    require_once('funcoes_sala.php');
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Origin: *');
    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
    	if(isset($_REQUEST['titulo'])) {
    		$array = array($_REQUEST['titulo']);
    		$posts = pesquisarPostagem($conexao, $array);
    		if($posts) {
    			echo json_encode($posts);
    		} else {
    			$status = array('status'=>'falha', 'mensagem'=>'Hmm, parece que não há nenhuma postagem com esse titulo. Tente novamente');
    			echo json_encode($status);
    		}
    	}


    	die();
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') { //possibilidade de apenas uma midia por post
    	if(isset($_REQUEST['criar_post'])) {
    		$post_content = $_REQUEST['post_text'];
            $user_id =  $_SESSION['id'];
            $sala_id = $_SESSION['sala_id'];
            /*
    		$postagem = criarPostagem($conexao, $array);
    		if($postagem) {
    			if($obj->nomeMidia) {
    				$array = array($obj->nomeMidia, $postagem['post_id']);
    				$resultado = inserirMidia($conexao, $array);
    				if(!$resultado) {
    					$status = array('status'=>'falha', "mensagem"=>"Houve um erro inserir uma midia na publicacao. Tente novamente");
    				} else {
    					$status = array('status'=>'sucesso');		
    				}
    			}
            	$status = array('status'=>'sucesso');
	        } else {
	            $status = array('status'=>'falha', "mensagem"=>"Houve um erro ao tentar criar a publicação. Tente novamente");
	        }
	         echo json_encode($status);
            */
          die();
	    	
	   	} else if($obj->funcao == 'comentar') {
            $user_id = $_SESSION['user_id'];
	   		$array = array($obj->conteudo, $user_id, $obj->post_id);
	   		$okay = criarComentario($conexao, $array);
	   		if($okay) {
	   			$status = array('status'=>'sucesso');		
	   		} else {
	   			$status = array('status'=>'falha', "mensagem"=>"Houve um erro ao tentar comentar nesta publicação. Tente novamente");
	   		}
	   		echo json_encode($status);
	   	} 
    	die();
    }

    if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    	if($obj->funcao == 'editar post') {
    		$array = array($obj->post_id, $obj->titulo, $obj->conteudo);
    		$okay = editarPostagem($conexao, $array);
    		if($okay) {
    			if($obj->nomeMidia) {
    				$array = array($obj->nomeMidia, $obj->post_id);
    				$editada = editarMidia($conexao, $array); //caso o post não tivesse midia antes disso. Agora passará a ter.
    				if($editada) {
    					$status = array('status'=>'sucesso');
    				} else {
    					$status = array('status'=>'erro ao tentar editar uma midia existente');
    				}
    			} else {
    				$array = array($obj->post_id);
    				$existe = verificaPostagem($conexao, $array); //verifica se a postagem possui alguma midia vinculada a ela.
    				if($existe) {
    					$deletada = deletarMidia($conexao, $array); //deleta a midia da postagem
    					if($deletada) {
    						$status = array('status'=>'sucesso');
	    				} else {
	    					$status = array('status'=>'falha', 'mensagem'=>'Falha ao tentar excluir a midia da postagem');
	    				}
    				}
    			}
    		} else {
    			$status = array('status'=>'falha', "mensagem"=>"Houve um erro ao tentar editar esta publicação. Tente novamente");	
    		}
    		echo json_encode($status);
    	}


    	die();
    }

    if($_SERVER['REQUEST_METHOD'] == 'delete') {
    	if(isset($_REQUEST['deletar_post'])) {
    		$post_id = $_REQUEST['post_id'];
    		$array = array($post_id);
    		$deletado = deletarPostagem($conexao, $array);
    		if($deletado) {
    			$status = array('status'=>'sucesso', 'mensagem'=>'Essa postagem foi deletada com sucesso');
    		} else {
    			$status = array('status'=>'falha', "mensagem"=>"Hmm, parece que não foi possivel deletar essa postagem. Tente novamente");	
    		}
    		echo json_encode($status);
    	}
    }

		



?>