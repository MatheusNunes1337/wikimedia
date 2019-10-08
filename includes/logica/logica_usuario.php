<?php
    require_once('conecta.php');
    require_once('funcoes_usuario.php');
#CADASTRO USUÁRIO
    if(isset($_POST['cadastrar'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $senhaEncriptada = base64_encode($senha);
        $array = array($nome, $email, $senhaEncriptada);
        cadastrarUsuario($conexao, $array);
        header('location:../../index.php');
    }
#FAZER LOGIN
    if(isset($_POST['entrar'])){
        $username = addslashes($_POST['username']);//impede que o sql seja alterado
        $senha = $_POST['senha'];
        $senhaEncriptada = base64_encode($senha);
        $array = array($username, $senhaEncriptada);
        $usuario = realizarLogin($conexao,$array);
        if($usuario){
            session_start();
            $_SESSION['logado'] = true;
            $_SESSION['id'] = $usuario['usuario_id'];
            $_SESSION['username'] = $usuario['username'];
            header('location:../../index.php');
        }
        else{
            header('location:../../login.php');
            ?>
            <script type="text/javascript">
                alert("Usuário ou senha incorretos");
            </script>
            <?php 
        }
    }

#LOGOUT
    if(isset($_POST['sair'])){
            session_start();
            session_destroy();
            header('location:../../login.php');
    }


#PESQUISAR USUÁRIO
    if(isset($_REQUEST['pesquisar_usuario'])) {
        $nome = $_REQUEST['nome'];
        $usuario = pesquisarUsuario($conexao, $nome);
        include "../../pesquisarUsuario.php";
    }

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



?>