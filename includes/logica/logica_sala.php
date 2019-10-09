<?php
    require_once('conecta.php');
    require_once('funcoes_sala.php');
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Origin: *');
    $json = file_get_contents('php://input');
    $obj = json_decode($json);


 if($_SERVER['REQUEST_METHOD'] == 'GET') {
    #BUSCAR SALA - funcao assincrona
    if($obj->funcao == 'buscar sala') {
        $array = [$obj->disciplina]
        $result = buscarSala($conexao, $array);
        if($result) {
            $status = array_push_assoc($result, 'status', 'sucesso') //ou array_push($result, 'status'=>'aaaa')
        } else {
            $status = array('status'=>'falha', "mensagem"=>"Hmm, parece que não há sala com essa disciplina"); //fazer o teste com o status = falha no response
        }
         echo json_encode($status);
         die();
    }
    #ACHA A SALA PARA ENVIAR AS INFORMAÇÕES PARA O FORMULÁRIO DE ALTERAÇÃO
    if(isset($_REQUEST['editar_sala'])) {
        $sala_id = $_REQUEST['editar_sala'];
        $array = array($sala_id);
        $salaInfo = acharSala($conexao, $array);
        if($salaInfo) {
            $status = array_push_assoc($salaInfo, 'status', 'sucesso');
        } else {
            $status = array('status'=>'falha', 'mensagem' => 'Não foi possivel selecionar essa sala para edição');
        }
        echo json_encode($status);
        die();
    }

    
 }   


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        #CRIAR UMA NOVA SALA
        if(isset($_POST['criar_sala'])){
            $nome = $_POST['sala_nome'];
            $descricao = $_POST['sala_descricao'];
            $nivel = $_POST['sala_nivel'];
            $max_membros = $_POST['sala_membros'];
            $conteudo = $_POST['sala_conteudo'];
            $disciplina = $_POST['sala_disciplina'];
            $array = array($nome, $descricao, $nivel, $max_membros);
            $array2 = array($conteudo, $disciplina);
            $sala = criarSala($conexao, $array);
            try {
                if($sala) {
                    $result1 = verificaAssunto($conexao, $array2);
                    if($result1) {
                        $result2 = inserirAssunto($conexao, $array2);
                        if($result2) {
                            $array2[2] = $nome;
                            $result3 = colocarAssunto($conexao, $array2);
                            if($result3) {
                                header('location:../../index.php');  
                            } 
                        } 
                    } 
                } else {
                    //pagina de cadastro da sala
                }
            } catch(PDOException $err) {
                echo 'Error: ' . $err->getMessage();
            }
            die();   
        }

        #ENVIAR SOLICITACAO PARA ENTRAR - assincrono
        if($obj->funcao = 'enviar solicitacao') {
            //$user_id = $_SESSION['user_id'];
            //$sala_id = $_REQUEST['sala_id'];
            $array = array($obj->user_id, $obj->sala_id);
            $result = enviarSolicitacao($conexao, $array);
            if($result) {
                $status = array('status'=>'sucesso', 'mensagem'=>'Solicitação enviada com sucesso. Aguarde o administrador da sala aceita-lá para você ingressar na mesma');
            } else {
                $status = array('status'=>'falha', 'mensagem'=>'Hmmm, parece que houve um erro ao tentar enviar uma solicitacao');
            }
            echo json_encode($status);
            die();
        }
        #ACEITAR SOLICITACAO - ADMIN ACTION - ASSINCRONO
        if($obj->funcao = 'aceitar solicitacao') {
            $array = array($obj->id_user, $obj->id_sala);
            $resultado = aceitarSolicitacao($conexao, $array);
            if($resultado) {
                $status = array('status'=>'sucesso');
            } else {
                $status = array('status'=>'falha', 'mensagem'=>'Hmmm, parece que houve um erro ao tentar aceitar essa solicitacao');
            }
            echo json_encode($status);
            die();
        }
                    
    }

     if ($_SERVER['REQUEST_METHOD'] == 'delete') {
        #DELETAR SALA - ADMIN ACTION
        if(isset($_POST['deletar_sala'])){
            $sala_id = $_REQUEST['sala_id'];
            $array = array($sala_id);
            $resultado = excluirSala($conexao, $array); 
            if($resultado) { //enviar aviso aos outros usuários sobre a sala deletada
                header('location:../../index.php');
            } else {
                echo "Houve um erro ao tentar sair da sala";
            }
            die();
        }
        if(isset($_POST['sair_sala'])) {
            $user_id = $_SESSION['user_id'];
            $array = array($user_id);
            $resultado = sairSala($conexao, $array);
            if($resultado) {
                header('location:../../index.php');
            } else {
                echo "Houve um erro ao tentar sair da sala. Tente novamente"
            }
            die(); 
        }
        if($obj->funcao = 'banir usuario') {
            $array = array($obj->id_user);
            $resultado = banirUsuario($conexao, $array);
            if($resultado) {
                    $status = array('status'=>'sucesso', 'mensagem'=>'O usuário foi banido com sucesso.');
                } else {
                    $status = array('status'=>'falha', 'mensagem'=>'Houve um erro ao tentar realizar esta operação. Tente novamente');
                }
                echo json_encode($status);
                die();
            }    
        }
     }

     if ($_SERVER['REQUEST_METHOD'] == 'put') {
            #ATUALIZAR SALA -  ADMIN ACTION
            if(isset($_POST['atualizar_sala'])){
                $sala_nome = $_REQUEST['sala_nome'];
                $sala_descricao = $_REQUEST['sala_descricao'];
                $sala_nivel = $_REQUEST['sala_nivel'];
                $sala_membros = $_REQUEST['sala_membros'];
                $sala_id = $_REQUEST['sala_id'];
                $sala_disciplina = $_REQUEST['sala_disciplina'];
                $sala_conteudo = $_REQUEST['sala_assunto'];
                $array = array($sala_nome, $sala_descricao, $sala_nivel, $sala_membros);
                $array2 = array($sala_conteudo, $sala_disciplina, $sala_nome);
                $resultado = editarInformacoes($conexao, $array, $array2);
                if($resultado) {
                     header('location:../../index.php');
                 } else {
                    echo "Houve um erro ao tentar atualizar as informacoes da sala";
                 }
                 die();

            }
            if($obj->funcao = 'tornar admin') {  //funcao assincrona
                //$id_sala = $_REQUEST['sala_id'];
                //$id_admin= $_REQUEST['tornar_admin']; //ID DO NOVO ADMINISTRADOR
                $array = array($obj->id_sala, $obj->id_admin);
                $resultado = tornarAdministrador($conexao, $array);
                if($resultado) {
                    $status = array('status'=>'sucesso', 'mensagem'=>'Operação realizada com sucesso. Agora você não é mais o administrador da sala');
                } else {
                    $status = array('status'=>'falha', 'mensagem'=>'Houve um erro ao tentar realizar esta operação. Tente novamente');
                }
                echo json_encode($status);
                die();
            }
        }   
               



?>
