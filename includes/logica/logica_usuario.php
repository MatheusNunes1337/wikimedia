<?php
    require_once('conecta.php');
    require_once('funcoes_usuario.php');
     header('Content-Type: text/html; application/json; charset=UTF-8 ');
    header('Access-Control-Allow-Origin: *');
    session_start();
    

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    #CADASTRO USUÁRIO
    if(isset($_POST['cadastrar'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $senhaEncriptada = base64_encode($senha);
        $array = array($username, $email, $senhaEncriptada);
        $okay = cadastrarUsuario($conexao, $array);
        if($okay) {
            header('location:../../forms/user/login.php');
        } else {
            header('location:../../forms/user/cadastro.php');
        }
        
    }
    #FAZER LOGIN
    if(isset($_POST['logar'])){
        $username = addslashes($_POST['username']); //impede que o sql seja alterado
        $senha = $_POST['senha'];
        $senhaEncriptada = base64_encode($senha);
        $array = array($username, $senhaEncriptada);
        $usuario = realizarLogin($conexao,$array);
        if($usuario){
            $_SESSION['logado'] = true;
            $_SESSION['id'] = $usuario['usuario_id'];
            $_SESSION['username'] = $usuario['username'];
            header('location:../../home.php');
        }
        else{
            /*
            header('location:../../login.php');
            ?>
            <script type="text/javascript">
                alert("Usuário ou senha incorretos");
            </script>
            <?php
            */
           header('location:../../forms/user/login.php');
        }
    }
    die();
}    


if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    if(isset($_REQUEST['username'])) {
        $array = array($_REQUEST['username']);
        $resultado = verificaUsername($conexao, $array);
        if($resultado) {
            $status = array('status'=>'okay', 'mensagem'=>'Esse nome de usuário é válido');
        } else {
            $status = array('status'=>'falha', 'mensagem'=>'Esse nome de usuário já existe');
        }
        echo json_encode($status);
    } 
    if(isset($_REQUEST['email'])) {
        $array = array($_REQUEST['email']);
        $resultado = verificaEmail($conexao, $array);
        if($resultado) {
            $status = array('status'=>'okay', 'mensagem'=>'Esse email é válido');
        } else {
            $status = array('status'=>'falha', 'mensagem'=>'Esse email já foi cadastrado');
        }
        echo json_encode($status);
    }

    if(isset($_REQUEST['adminPass'])) {
        $senhaCriptografada = base64_encode($_REQUEST['adminPass']);
        $user_id = $_SESSION['id'];
        $array = array($senhaCriptografada, $user_id);
        $resultado = verificaSenhaAdm($conexao, $array);
        if($resultado) {
            $status = array('status'=>'okay', 'mensagem'=>'A senha está correta');
        } else {
            $status = array('status'=>'falha', 'mensagem'=>'Parece que está não é a sua senha');
        }
        echo json_encode($status);
    }

     if(isset($_REQUEST['infoUser'])) { //verificada
        $user_id = $_SESSION['id'];
        $array = array($user_id);
        $userInfo = acharUser($conexao, $array);
        if($userInfo) {
            $userInfo['senha'] = base64_decode($userInfo['senha']);
            $status = $userInfo; 
            $status['status'] = 'sucesso';
        } else {
            $status = array('status'=>'falha', 'mensagem' => 'Não foi possivel selecionar esse usuário para edição');
        }
        echo json_encode($status);
        die();
    }

    if(isset($_REQUEST['excluir_usuario'])) {
        $idUser = $_SESSION['id'];
        $array = array($idUser);
        $result = excluirPerfil($conexao, $array);
        echo var_dump($result); die();
        if($result) {
            session_destroy();
            $status = array('status'=>'sucesso');
        } else {
             $status = array('status'=>'falha', 'mensagem'=>'Houve um erro ao tentar excluir a sua conta. Tente novamente mais tarde');
        }    
    }
     die(); 
    
    /*
    #PESQUISAR USUÁRIO
    funcao assincrona
    if($obj->funcao == 'buscar usuario') {
        $nome = $_REQUEST['nome'];
        $usuario = pesquisarUsuario($conexao, $nome);
        include "../../pesquisarUsuario.php";
    }
    */
}



if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    #EXCLUIR USUARIO LOGADO
    $json = file_get_contents('php://input');
    $obj = json_decode($json);
    if($obj->funcao === 'excluir conta') {
        $idUser = $_SESSION['id'];
        $array = array($idUser);
        $result = excluirPerfil($conexao, $array);
        if($result) {
            session_destroy();
            $status = array('status'=>'sucesso');
        } else {
             $status = array('status'=>'falha', 'mensagem'=>'Houve um erro ao tentar excluir a sua conta. Tente novamente mais tarde');
        }
         echo json_encode($status);
         die();    
    }   
}


if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    #ALTERAR PERFIL DO USUÁRIO LOGADO 
    if(isset($_REQUEST['atualizar_usuario'])) {
        $id = $_REQUEST['numero_id'];
        $senha = base64_encode($_POST['senha']);
        $email = $_POST['email'];
        $array = array($senha, $email, $id);
        $result = alterarPerfil($conexao, $array);
        if($result) {
             header('location:../../index.php');
         } else {
            echo "erro ao tentar atualizar o perfil";
         }
    }           
}

#LOGOUT
    if(isset($_POST['sair'])){
            session_start();
            session_destroy();
            header('location:../../login.php');
    }

?>