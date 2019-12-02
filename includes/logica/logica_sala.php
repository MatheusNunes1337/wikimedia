<?php
    header('Content-Type: text/html; application/json; charset=UTF-8 ');
    header('Access-Control-Allow-Origin: *');
    session_start();
    require_once('conecta.php');
    require_once('funcoes_sala.php');
    require_once('funcoes_admin.php');
    require_once('funcoes_usuario.php');


 if($_SERVER['REQUEST_METHOD'] == 'GET') { //verificada
    $json = file_get_contents('php://input');
    $obj = json_decode($json);
    #BUSCAR SALA - funcao assincrona
    if(isset($_REQUEST['disciplina'])) {
        $array = array($_SESSION['id'], $_SESSION['id'], $_SESSION['id']);
        $result = buscarSala($conexao, $array, $_REQUEST['disciplina']);
        if($result) {
            $status = $result; 
        } else {
            $status = array('status'=>'falha', "mensagem"=>"Hmm, parece que não há salas referentes à esta disciplina"); 
        }
         echo json_encode($status);
         die();
    }
    #ACHA A SALA PARA ENVIAR AS INFORMAÇÕES PARA O FORMULÁRIO DE ALTERAÇÃO
    if(isset($_REQUEST['infoSala'])) { //verificada
        $sala_id = $_SESSION['sala_id'];
        $array = array($sala_id);
        $salaInfo = acharSala($conexao, $array);
        if($salaInfo) {
            $status = $salaInfo; 
            $status['status'] = 'sucesso';
        } else {
            $status = array('status'=>'falha', 'mensagem' => 'Não foi possivel selecionar essa sala para edição');
        }
        echo json_encode($status);
        die();
    }

    if(isset($_REQUEST['entrar_sala'])) { //verficada
        $_SESSION['sala_id'] = $_REQUEST['entrar_sala'];
        $array = array($_REQUEST['entrar_sala'], $_SESSION['id']);
        $result = verificaUser($conexao, $array);
        if($result) {
            $_SESSION['admin'] = 'admin';
        }
        header('location:../../sala.php');
        die();
    }

    if(isset($_REQUEST['listarUsuarios'])) { //verificada
        $array = array($_SESSION['sala_id'], $_SESSION['sala_id']);
        $usuarios = listarUsuarios($conexao, $array);
        if(empty($usuarios)) {
            $retorno = array('status'=>'vazio', 'mensagem'=>'Parece que não há nenhum usuário dentro desta sala.');
        } else {
            $retorno = $usuarios;
        }
        echo json_encode($retorno);
        die();
    }
    if(isset($_REQUEST['listarSolicitacoes'])) {
        $array = array($_SESSION['sala_id']);
        $solicitacoes = listarSolicitacoes($conexao, $array);
        if(empty($solicitacoes)) {
            $retorno = array('status'=>'vazio', 'mensagem'=>'Parece que não há nenhuma solicitacão para esta sala.');
        } else {
            $retorno = $solicitacoes;
        }
        echo json_encode($retorno);
        die();
    }
    if(isset($_REQUEST['listarSalas'])) {
        $array = array($_SESSION['id']);
        $salas = listarSalas($conexao, $array);
        if(empty($salas)) {
            $retorno = array('status'=>'vazio', 'mensagem'=>'Parece que você ainda não entrou em nenhuma sala.');
        } else {
            $retorno = $salas;
        }
        echo json_encode($retorno);
        die();
    }

    
 }   


    else if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $json = file_get_contents('php://input');
        $obj = json_decode($json);

        #CRIAR UMA NOVA SALA
        if(isset($_POST['criar_sala'])){ ////verificada
            $user_id = $_SESSION['id'];
            $nome = $_POST['sala_nome'];
            $descricao = $_POST['sala_descricao'];
            $nivel = $_POST['sala_nivel'];
            $max_membros = $_POST['sala_membros'];
            $conteudo = $_POST['sala_conteudo'];
            $disciplina = $_POST['sala_disciplina'];
            $array = array($nome, $descricao, $nivel, $max_membros, $user_id);
            $array2 = array($conteudo, $disciplina);
            $sala = criarSala($conexao, $array);
            try {
                if($sala) {
                    $result1 = verificaAssunto($conexao, $array2);
                    if($result1) {
                        $result2 = inserirAssunto($conexao, $array2);
                    }
                    $array2[2] = $nome;
                    $result3 = colocarAssunto($conexao, $array2);
                    $array = array($user_id, $nome);
                    $resultado = inserirAdministrador($conexao, $array);
                    header('location:../../minhas_salas.php');   
                } 
            } catch(PDOException $err) {
                echo 'Error: ' . $err->getMessage();
            }
            die();   
        }

         #DELETAR SALA - ADMIN ACTION - É UMA AÇÃO DE DELETAR MAS NÃO PODE SER ASSINCRONA, ENTÃO ESTA NO METHOD POST
        if(isset($_POST['deletar_sala'])){ //verificada - UTILIZAÇÃO DO ON DELETE CASCADE NAS TABELAS FILHAS DA TABELA SALAS
            $sala_id = $_SESSION['sala_id'];
            $array = array($sala_id);
            try {
                $resultado = excluirSala($conexao, $array); 
                header('location:../../home.php');    
            } catch(PDOException $err) {
                echo 'Error: ' . $err->getMessage();
            }
            die();
        }

        #ENVIAR SOLICITACAO PARA ENTRAR - assincrono
        
        if($obj->funcao == "enviar solicitacao") { //verificada
            $user_id = $_SESSION['id'];
            $sala_id = $obj->sala_id;
            $array = array($user_id, $sala_id);
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
        if($obj->funcao == 'aceitar solicitacao') { //verificada
            $user_id = $obj->user_id;
            $sala_id = $_SESSION['sala_id'];
            $array = array($user_id, $sala_id);
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

    else if ($_SERVER['REQUEST_METHOD'] == 'PUT') { //verificada
            $json = file_get_contents('php://input');
            $obj = json_decode($json);

            #ATUALIZAR SALA -  ADMIN ACTION
            if($obj->funcao == 'editar sala'){
                $sala_nome = $obj->nome;
                $sala_descricao = $obj->descricao;
                $sala_nivel = $obj->nivel;
                $sala_membros = $obj->max_membros;
                $sala_id = $_SESSION['sala_id'];
                $sala_disciplina = $obj->disciplina;
                $sala_conteudo = $obj->conteudo;
                $array = array($sala_nome, $sala_descricao, $sala_nivel, $sala_membros, $sala_id);
                $array2 = array($sala_conteudo, $sala_disciplina, $sala_nome);
                $resultado = editarInformacoes($conexao, $array, $array2);
                if($resultado) {
                     $status = array('status'=>'sucesso', 'mensagem'=>'As informações foram atualizadas com sucesso.');
                 } else {
                    $status = array('status'=>'falha', 'mensagem'=>'Houve um erro ao tentar atualizar as informações desta sala. Tente novamente.');
                 }
                 echo json_encode($status);
                 die();

            }
            if($obj->funcao == 'tornar admin') {  //verificada
                $admin_id = $obj->user_id; //id do usuário que se tornará admin
                $sala_id = $_SESSION['sala_id'];
                $array = array($admin_id, $sala_id);
                $resultado = tornarAdministrador($conexao, $array);
                if($resultado) {
                    $status = array('status'=>'sucesso', 'mensagem'=>'Operação realizada com sucesso. Agora você não é mais o administrador da sala');
                        unset($_SESSION['admin']);
                } else {
                    $status = array('status'=>'falha', 'mensagem'=>'Houve um erro ao tentar realizar esta operação. Tente novamente');
                }
                echo json_encode($status);
                die();
            }
        } else { //DELETE METHOD

        $json = file_get_contents('php://input');
        $obj = json_decode($json);

        if($obj->funcao === 'sair sala') { //É UM DELETE PORÉM SERÁ USADO COMO GET, pois será mais simples.
            $user_id = $_SESSION['id'];
            $id_sala = $obj->sala_id;
            $array = array($user_id, $id_sala);
            $resultado = sairSala($conexao, $array);
            if($resultado) {
                $status = array('status'=>'sucesso');
            } else {
                $status = array('status'=>'falha', 'mensagem'=>'Houve um erro ao tentar realizar esta operação. Tente novamente');
            }
            echo json_encode($status);
            die();   
        }

        if($obj->funcao === 'banir usuario') { //verificada
            $user_id = $obj->user_id;
            $sala_id = $_SESSION['sala_id'];
            $array = array($user_id, $sala_id);
            $resultado = banirUsuario($conexao, $array);
            if($resultado) {
                    $status = array('status'=>'sucesso', 'mensagem'=>'O usuário foi banido com sucesso.');
                } else {
                    $status = array('status'=>'falha', 'mensagem'=>'Houve um erro ao tentar realizar esta operação. Tente novamente');
                }
                echo json_encode($status);
            die();    
        }

        if($obj->funcao === 'negar solicitacao') { //verificada
            $user_id = $obj->user_id;
            $sala_id = $_SESSION['sala_id'];
            $array = array($user_id, $sala_id);
            $resultado = negarSolicitacao($conexao, $array);
            
            if($resultado) {
                $status = array('status'=>'sucesso');
            } else {
                $status = array('status'=>'falha', 'mensagem'=>'Hmmm, parece que houve um erro ao tentar negar essa solicitacao');
            }
            echo json_encode($status);
            die();
        }

    }    

?>