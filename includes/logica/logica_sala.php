<?php
    session_start();
    require_once('conecta.php');
    require_once('funcoes_sala.php');
    require_once('funcoes_admin.php');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: charset=UTF-8');


 if($_SERVER['REQUEST_METHOD'] == 'GET') { //verificada
    $json = file_get_contents('php://input');
    $obj = json_decode($json);
    #BUSCAR SALA - funcao assincrona
    if(isset($_REQUEST['disciplina'])) {
        $array = array($_REQUEST['disciplina']);
        $result = buscarSala($conexao, $array);
        if($result) {
            $status = $result; 
        } else {
            $status = array('status'=>'falha', "mensagem"=>"Hmm, parece que não há sala com essa disciplina"); 
        }
         echo json_encode($status);
         die();
    }
    #ACHA A SALA PARA ENVIAR AS INFORMAÇÕES PARA O FORMULÁRIO DE ALTERAÇÃO
    if(isset($_REQUEST['infoSala'])) { //funcao assincrona
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
        $sala_id = $_REQUEST['sala_id'];
        $_SESSION['sala_id'] = $sala_id;
        header('location:../../sala.php');
    }

    
 }   


    else if ($_SERVER['REQUEST_METHOD'] == 'POST') { //verificada
        $json = file_get_contents('php://input');
        $obj = json_decode($json);

        #CRIAR UMA NOVA SALA
        if(isset($_POST['criar_sala'])){
            $user_id = 5;
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
                    $result2 = inserirAssunto($conexao, $array2);
                    $array2[2] = $nome;
                    $result3 = colocarAssunto($conexao, $array2);
                    if($result3) {
                        header('location:../../index.php');  
                    }   
                } else {
                    echo var_dump($array);
                }
            } catch(PDOException $err) {
                echo 'Error: ' . $err->getMessage();
            }
            die();   
        }

         #DELETAR SALA - ADMIN ACTION - É UMA AÇÃO DE DELETAR MAS NÃO PODE SER ASSINCRONA, ENTÃO ESTA NO METHOD POST
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

    else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
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
                var_dump($resultado);
                /*
                if($resultado) {
                     header('location:../../home.php');
                 } else {
                    echo "Houve um erro ao tentar atualizar as informacoes da sala";
                 }*/
                 die();

            }
            if($obj->funcao == 'tornar admin') {  //funcao assincrona
                $admin_id = $obj->user_id; //id do usuário que se tornará admin
                $sala_id = $_SESSION['sala_id'];
                $array = array($admin_id, $sala_id);
                $resultado = tornarAdministrador($conexao, $array);
                echo var_dump($resultado);
                /*
                if($resultado) {
                    $status = array('status'=>'sucesso', 'mensagem'=>'Operação realizada com sucesso. Agora você não é mais o administrador da sala');
                } else {
                    $status = array('status'=>'falha', 'mensagem'=>'Houve um erro ao tentar realizar esta operação. Tente novamente');
                }
                echo json_encode($status);
                */
                die();
            }
        } else { //DELETE METHOD

        $json = file_get_contents('php://input');
        $obj = json_decode($json);

        if(isset($_POST['sair_sala'])) {
            $user_id = $_SESSION['id'];
            $array = array($user_id);
            $resultado = sairSala($conexao, $array);
            if($resultado) {
                header('location:../../home.php');
            } else {
                echo "Houve um erro ao tentar sair da sala. Tente novamente";
            }
            die(); 
        }
        if($obj->funcao == 'banir usuario') { //verificada
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
        }
        if($obj->funcao == 'negar solicitacao') { //verificada
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
               



?>
