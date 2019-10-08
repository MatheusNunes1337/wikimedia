<?php
    require_once('conecta.php');
    require_once('funcoes_sala.php');


 if($_SERVER['REQUEST_METHOD'] == 'GET') {
    #BUSCAR SALA
    if(isset($_REQUEST['buscar_sala'])) {
        $disciplina = $_REQUEST['disciplina'];
        $result = buscarSala($conexao, $disciplina);
        if($result) {
            $result = array_push_assoc($result, 'status', 'sucesso') //ou array_push($result, 'status'=>'aaaa')
            echo json_encode($result);
        } else {
            $status = array("status"=>"Hmm, parece que não há sala com essa disciplina");
        }
    }
    #ACHA A SALA PARA ENVIAR AS INFORMAÇÕES PARA O FORMULÁRIO DE ALTERAÇÃO
    if(isset($_REQUEST['editar_sala'])) {
        $sala_id = $_REQUEST['editar_sala'];
        $array = array($sala_id);
        $salaInfo = acharSala($conexao, $array);
        if($salaInfo) {
            $salaInfo = array_push_assoc($salaInfo, 'status', 'sucesso');
            echo json_encode($salaInfo);
        } else {
            $status = array('status' => 'Não foi possivel selecionar essa sala para edição');
            echo json_encode($status);
        }
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
        }

        #ENVIAR SOLICITACAO PARA ENTRAR
        if(isset($_REQUEST['enviar_request'])) {
            $user_id = $_SESSION['user_id'];
            $sala_id = $_REQUEST['sala_id'];
            $array = array($user_id, $sala_id);
            $result = enviarSolicitacao($conexao, $array);
            if($result) {
                $status = array('status'=>'Solicitação enviada com sucesso. Aguarde o administrador da sala aceita-lá para você ingressar na mesma');
                echo json_encode($status);
            } else {
                $status = array('status'=>'Hmmm, parece que houve um erro ao tentar enviar uma solicitacao');
                echo json_encode($status);
            }
        }
        #SAIR DA SALA
        if(isset($_POST['sair_sala'])){
            $user_id = $_SESSION['user_id'];
            $array = array($user_id);
            $resultado = sairSala($conexao, $array);
            if($resultado) {
                header('location:../../index.php');
            } else {
                echo "Houve um erro ao tentar sair da sala";
            }    
        }

        if ($_SERVER['REQUEST_METHOD'] == 'put') {
            #ATUALIZAR SALA
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

            }
        }                 
    }

     if ($_SERVER['REQUEST_METHOD'] == 'delete') {
        #DELETAR SALA
        if(isset($_POST['deletar_sala'])){
            $sala_id = $_REQUEST['sala_id'];
            $array = array($sala_id);
            $resultado = excluirSala($conexao, $array); 
            if($resultado) { //enviar aviso aos outros usuários sobre a sala deletada
                header('location:../../index.php');
            } else {
                echo "Houve um erro ao tentar sair da sala";
            }
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
        }
     }   
               



?>
