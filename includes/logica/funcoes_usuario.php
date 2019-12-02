<?php
 
    function cadastrarUsuario($conexao,$array){
       try {
            $query = $conexao->prepare("insert into usuarios (username, email, senha) values (?, ?, ?)");
            $usuario = $query->execute($array);
        
            return $usuario;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }
    
    /*
    function listarUsuarios($conexao){
      try {
        $query = $conexao->prepare("select * FROM usuarios");      
        $query->execute();
        $usuarios = $query->fetchAll();
        return $usuarios;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  

    }
    */
  
      function realizarLogin($conexao,$array){
        try {
        $query = $conexao->prepare("select * from usuarios where username=? and senha=?");
        if($query->execute($array)){
            $usuario = $query->fetch(); //coloca os dados num array $usuario
          if ($usuario)
            {  
                return $usuario;
            }
        else
            {
                return false;
            }
        }
        else{
            return false;
        }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
    }


    function excluirPerfil($conexao, $array) {
        try {
            $query = $conexao->prepare("delete from usuarios where usuario_id = ?");
            $usuario = $query->execute($array);
            return $usuario;    
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function alterarPerfil($conexao, $array) {
         try {
            $query = $conexao->prepare("update usuarios set username = ?, email = ?, senha= ?, foto = ? where usuario_id = ?");
            $usuario = $query->execute($array);   
            return $usuario;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function atualizarPerfil($conexao, $array) { //semelhante a acima, porém não faz o update da imagem
         try {
            $query = $conexao->prepare("update usuarios set username = ?, email = ?, senha= ? where usuario_id = ?");
            $usuario = $query->execute($array);   
            return $usuario;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

     function verificaUsername($conexao, $array) {
         try {
            $query = $conexao->prepare("select * from usuarios where username = ?");
            if($query->execute($array)){
                $query->fetch();
                if($query->rowCount() < 1) {
                    $resultado = true;
                } else {
                    $resultado = false;
                }
                return $resultado;
            }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
         }  
    }

     function verificaEmail($conexao, $array) {
         try {
            $query = $conexao->prepare("select * from usuarios where email = ?");
            if($query->execute($array)){
                $query->fetch();
                if($query->rowCount() < 1) {
                    $resultado = true;
                } else {
                    $resultado = false;
                }
                return $resultado;
            }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
         }  
    }

    function verificaSenhaAdm($conexao, $array) {
       try {
            $query = $conexao->prepare("select senha from usuarios where senha = ? AND usuario_id = ?");
            if($query->execute($array)){
                $query->fetch();
                if($query->rowCount() == 1) {
                    $resultado = true;
                } else {
                    $resultado = false;
                }
                return $resultado;
            }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
         }  
    }

    function acharUser($conexao,$array){
        try {
        $query = $conexao->prepare("select username, email, senha, foto from usuarios
            where usuario_id = ?");
        if($query->execute($array)){
            $user = $query->fetch(PDO::FETCH_ASSOC); 
            return $user;
        }
        else{
            return false;
        }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
    }

    function verificaUser($conexao, $array) {
       try {
            $query = $conexao->prepare("select * from salas where sala_id = ? AND usuario_id = ?");
            if($query->execute($array)){
                $query->fetch();
                if($query->rowCount() == 1) {
                    $resultado = true;
                } else {
                    $resultado = false;
                }
                return $resultado;
            }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
         }  
    }

    
   ?>