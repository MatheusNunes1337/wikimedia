<?php
    require_once('conecta.php');
    require_once('funcoes_sala.php');
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
#ENTRAR
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

/*
#DELETAR USUÁRIO
    if(isset($_POST['deletar'])){
        $id = $_REQUEST['deletar'];
        $array=array($id);
        deletarUsuario($conexao, $array);

        header('Location:../../index.php');
    }
*/

#PESQUISAR USUÁRIO
    if(isset($_REQUEST['pesquisar'])) {
        $nome = $_REQUEST['nome'];
        $usuario = pesquisarUsuario($conexao, $nome);
        include "../../pesquisarUsuario.php";
    }

#EXCLUIR USUARIO LOGADO
    if(isset($_REQUEST['excluir'])) {
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
    if(isset($_REQUEST['atualizar'])) {
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
