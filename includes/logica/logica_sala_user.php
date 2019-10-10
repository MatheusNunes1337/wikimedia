<?php  
	require_once('conecta.php');
    require_once('funcoes_sala.php');
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Origin: *');
    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    if($_SERVER['REQUEST_METHOD'] == 'GET') {



    	die();
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
    	if($obj->funcao == 'criar post') {
    		$array = array($obj->titulo, $obj->conteudo);
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
	    	}
	   	} else if($obj->funcao == 'comentar') {

	   	} 
    	die();
    }

    if($_SERVER['REQUEST_METHOD'] == 'PUT') {



    	die();
    }

    if($_SERVER['REQUEST_METHOD'] == 'delete') {




    }	
	
	
	



?>