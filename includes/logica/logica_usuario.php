<?php
    require_once('conecta.php');
    require_once('funcoes_usuario.php');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: charset=UTF-8');
    

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
            session_start();
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
        session_start();
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



if($_SERVER['REQUEST_METHOD'] == 'delete') {
    #EXCLUIR USUARIO LOGADO
    if(isset($_REQUEST['excluir_usuario'])) {
        session_start();
        $idUser = $_SESSION['id'];
        $array = array($idUser);
        $result = excluirPerfil($conexao, $array);
        if($result) {
            session_destroy();
            header('location:../../index.php');
        } else {
            header('location:../../index.php');
        }    
    }
     die();    
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