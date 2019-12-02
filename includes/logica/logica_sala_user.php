<?php  
	require_once('conecta.php');
    require_once('funcoes_sala_user.php');
    header('Content-Type: text/html; application/json; charset=UTF-8 ');
    header('Access-Control-Allow-Origin: *');
    session_start();

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $json = file_get_contents('php://input');
        $obj = json_decode($json);

    	if(isset($_REQUEST['conteudo'])) {
    		$array = array($_SESSION['sala_id']);
    		$posts = buscarPostagem($conexao, $array, $_REQUEST['conteudo']);
    		if(!empty($posts)) {
    			$status = $posts;
    		} else {
    			$status = array('status'=>'vazio', 'mensagem'=>'Hmm, parece que não há nenhuma postagem referente a isso. Tente novamente');
    		}
            echo json_encode($status);
            die();
    	}
        if(isset($_REQUEST['listarPostagens'])) {
            $id_sala = $_SESSION['sala_id'];
            $array = array($id_sala);
            $posts = listarPostagens($conexao, $array);
            if(empty($posts)) {
                $status = array('status'=>'vazio', 'mensagem'=>'Parece que está sala ainda não possui nenhuma postagem. Seja o primeiro a compartilhar algo!');
            } else {
    
                $status = $posts;
            }
            echo json_encode($status);
            die();
        }
        if(isset($_REQUEST['listarComentarios'])) {
            $id_post = $_REQUEST['post_id'];
            $array = array($id_post);
            $coments = listarComentarios($conexao, $array);
            if(empty($coments)) {
                $status = array('status'=>'vazio');
            } else {
                $status = $coments;
            }
            echo json_encode($status);
            die();
        }

    }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') { //possibilidade de apenas uma midia por post
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
    	if(isset($_REQUEST['criar_post'])) {
    		$post_content = $_REQUEST['post_text'];
            $user_id =  $_SESSION['id'];
            $sala_id = $_SESSION['sala_id'];
            
            /* Config_upload */
            $limitar_ext="sim";
     
            //extensões autorizadas
            $extensoes_validas= array(".gif",".jpg",".jpeg",".bmp",".GIF",".JPG",".JPEG",".BMP",".PNG",".png", ".docx", ".pdf", ".txt", ".xlsx", ".odt", ".ods");

            // caminho absoluto onde os arquivos serão armazenados
            /*
            $tipo_arquivo = $_FILES['post_media']['type'];
            if(strpos($tipo_arquivo, 'image') !== false) {
                $caminho="../componentes/medias/imagens";   
            } else {
                $caminho="../componentes/medias/outros";   
            }
            */
            $caminho="../componentes/medias";
            // limitar o tamanho do arquivo? (sim ou não)
            $limitar_tamanho="sim";

            //tamanho limite do arquivo em bytes
            $tamanho_bytes="60000000";

            /*executa_upload*/

            $nome_arquivo=$_FILES['post_media']['name'];  
            $tamanho_arquivo=$_FILES['post_media']['size'];
            $arquivo_temporario=$_FILES['post_media']['tmp_name'];

            if (!empty($nome_arquivo)) {
            
           
                if($limitar_tamanho=="sim" && ($tamanho_arquivo > $tamanho_bytes))  { 
                    $status = array("status"=>"falha", "mensagem"=>"Falha! Parece que você enviou uma imagem acima de 3MB. Tente novamente com uma imagem de tamanho inferior.");
                    echo json_encode($status);
                    die();
                }
                
                $ext = strrchr($nome_arquivo,'.');
                if (($limitar_ext == "sim") && !in_array($ext,$extensoes_validas)) {
                    $status = array("status"=>"falha", "mensagem"=>"Falha! Você deve selecionar apenas midias compatíveis. Tente novamente usando o formato correto.");
                    echo json_encode($status);
                    die();
                }    
               
                if (!move_uploaded_file($arquivo_temporario, "$caminho/$nome_arquivo"))
                {
                    $status = array("status"=>"falha", "mensagem"=>"Falha! O arquivo não pôde ser copiado para o servidor");
                    echo json_encode($status);
                    die();    
                }

            } else {
                $nome_arquivo = NULL;
            }
            $array = array($post_content, $user_id, $sala_id, $nome_arquivo);
            $postagem = criarPostagem($conexao, $array);
            if($postagem) {
               $status = array('status'=>'sucesso'); 
           } else {
              $status = array('status'=>'falha', "mensagem"=>"Houve um erro inserir a postagem na base de dados Tente novamente");  
           }
           echo json_encode($status);
           die();
        }    
	    	
   	    else if($obj->funcao == 'criar comentario') {
        $user_id = $_SESSION['id'];
   		$array = array($obj->conteudo, $user_id, $obj->post_id);
   		$okay = criarComentario($conexao, $array);
   		if($okay) {
   			$status = array('status'=>'sucesso');		
   		} else {
   			$status = array('status'=>'falha', "mensagem"=>"Houve um erro ao tentar comentar nesta publicação. Tente novamente");
   		}
   		   echo json_encode($status);
    	   die();
        }
    }


    if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
    	if($obj->funcao == 'excluir postagem') {
    		$id_post = $obj->postagem_id;
    		$array = array($id_post);
    		$deletado = deletarPostagem($conexao, $array);
    		if($deletado) {
    			$status = array('status'=>'sucesso', 'mensagem'=>'Essa postagem foi deletada com sucesso');
    		} else {
    			$status = array('status'=>'falha', "mensagem"=>"Hmm, parece que não foi possivel deletar essa postagem. Tente novamente");	
    		}
    		echo json_encode($status);
    	}
    }



    if($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
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
?>