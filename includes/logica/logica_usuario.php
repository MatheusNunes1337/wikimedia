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
            header('location:../../login.php');
        } else {
            header('location:../../cadastro.php');
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
            $_SESSION['img_profile'] = $usuario['foto'];
            header('location:../../home.php');
        }
        else{
           header('location:../../login.php');
        }
        die();
    }
     if(isset($_POST['atualizar_perfil'])) { //É UM METODO PUT PORÉM SERÁ FEITO COMO POST
        $id_user = $_SESSION['id'];
        $nomeUsuario = $_REQUEST['user_username'];
        $senha = base64_encode($_REQUEST['user_senha']);
        $email = $_REQUEST['user_email'];

         /* Config_upload */
        $limitar_ext="sim";
 
        //extensões autorizadas
        $extensoes_validas=array(".gif",".jpg",".jpeg",".bmp",".GIF",".JPG",".JPEG",".BMP",".PNG",".png");

        // caminho absoluto onde os arquivos serão armazenados
        $caminho="../componentes/imagens/usuarios";

        // limitar o tamanho do arquivo? (sim ou não)
        $limitar_tamanho="sim";

        //tamanho limite do arquivo em bytes
        $tamanho_bytes="30000000";

        /*executa_upload*/

        $nome_arquivo=$_FILES['user_foto']['name'];  
        $tamanho_arquivo=$_FILES['user_foto']['size'];
        $arquivo_temporario=$_FILES['user_foto']['tmp_name'];

        if (!empty($nome_arquivo))
        {
           
            if($limitar_tamanho=="sim" && ($tamanho_arquivo > $tamanho_bytes))  { 
                $status = array("status"=>"falha", "mensagem"=>"Falha! Parece que você enviou uma imagem acima de 3MB. Tente novamente com uma imagem de tamanho inferior.");
                echo json_encode($status);
                die();
            }
                
            $ext = strrchr($nome_arquivo,'.');
            if (($limitar_ext == "sim") && !in_array($ext,$extensoes_validas)) {
                $status = array("status"=>"falha", "mensagem"=>"Falha! Você deve selecionar apenas arquivos de imagem. Tente novamente usando o formato correto.");
                echo json_encode($status);
                die();
            }    
               
            if (move_uploaded_file($arquivo_temporario, "$caminho/$nome_arquivo"))
            {
                  $array = array($nomeUsuario, $email, $senha, $nome_arquivo, $id_user);
                  $result = alterarPerfil($conexao, $array);
                   if($result) {
                        $status = array('status'=>'sucesso', 'mensagem'=>'Informações da conta atualizadas com sucesso.'); 
                    } else {
                        $status = array('status'=>'falha', 'mensagem'=>'Ocorreu um erro ao tentar atualizar o perfil. Tente novamente mais tarde.');
                    }
                    echo json_encode($status);
            }
            else
            {
                $status = array("status"=>"falha", "mensagem"=>"Falha! O arquivo não pôde ser copiado para o servidor.");
                 echo json_encode($status);
                 die();
            }
        } else {
            $array = array($nomeUsuario, $email, $senha, $id_user);
            $result = atualizarPerfil($conexao, $array);
           if($result) {
                $status = array('status'=>'sucesso', 'mensagem'=>'Informações da conta atualizadas com sucesso.'); 
            } else {
                $status = array('status'=>'falha', 'mensagem'=>'Ocorreu um erro ao tentar atualizar o perfil. Tente novamente mais tarde.');
            }
            echo json_encode($status);
        }

     }
     die();   
}    


if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    if(isset($_REQUEST['username'])) {
        $tamanho = strlen($_REQUEST['username']);
        if($tamanho < 6 || $tamanho > 12) {
           $status = array('status'=>'invalido', 'mensagem'=>'O nome de usuário deve ter de 6 a 12 caracteres.');
           echo json_encode($status);
           die();
        }
        $array = array($_REQUEST['username']);
        $resultado = verificaUsername($conexao, $array);
        if($resultado) {
            $status = array('status'=>'okay', 'mensagem'=>'Esse nome de usuário é válido.');
        } else {
            $status = array('status'=>'falha', 'mensagem'=>'Esse nome de usuário já existe.');
        }
        echo json_encode($status);
    } 

    //VERIFICAÇÃO DO EMAIL
    if(isset($_REQUEST['email'])) {
        $email = $_REQUEST['email'];
        if(!strpos($email, '@')) {
            $status = array('status'=>'invalido', 'mensagem'=>'O formato de email que você inseriu é inválido.');
            echo json_encode($status);
            die(); 
        }
        $array = array($_REQUEST['email']);
        $resultado = verificaEmail($conexao, $array);
        if($resultado) {
            $status = array('status'=>'okay', 'mensagem'=>'Esse email é válido.');
        } else {
            $status = array('status'=>'falha', 'mensagem'=>'Esse email já foi cadastrado.');
        }
        echo json_encode($status);
    }

    if(isset($_REQUEST['adminPass'])) {
        $senhaCriptografada = base64_encode($_REQUEST['adminPass']);
        $user_id = $_SESSION['id'];
        $array = array($senhaCriptografada, $user_id);
        $resultado = verificaSenhaAdm($conexao, $array);
        if($resultado) {
            $status = array('status'=>'okay', 'mensagem'=>'A senha está correta.');
        } else {
            $status = array('status'=>'falha', 'mensagem'=>'Parece que a sua senha está incorreta.');
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
            $status = array('status'=>'falha', 'mensagem' => 'Não foi possivel carregar as informações do usuário.');
        }
        echo json_encode($status);
        die();
    }

    if(isset($_REQUEST['excluir_usuario'])) {
        $idUser = $_SESSION['id'];
        $array = array($idUser);
        $result = excluirPerfil($conexao, $array);
        if($result) {
            session_destroy();
            $status = array('status'=>'sucesso');
        } else {
             $status = array('status'=>'falha', 'mensagem'=>'Houve um erro ao tentar excluir a sua conta. Tente novamente mais tarde');
        }
        die();     
    }
    
     if(isset($_REQUEST['verificaUser'])) {
        $array = array($_REQUEST['id_sala'], $_SESSION['id']);
        $user = verificaUser($conexao, $array);
        if(!$user) {
            $retorno = array('status'=>'okay');
        } else {
            $retorno = array('status'=>'é o administrador', 'mensagem'=>'Parece que você é o administrador dessa sala. Para continuar com esta operação é necessário primeiramente que você nomeie outro membro como administrador.');
        }
        echo json_encode($retorno);
        die();
    }
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


#LOGOUT
if(isset($_POST['sair'])){
        session_start();
        session_destroy();
        header('location:../../login.php');
}

?>