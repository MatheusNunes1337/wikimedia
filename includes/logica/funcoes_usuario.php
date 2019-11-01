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
    function alterarUsuario($conexao, $array){
        try {
            $query = $conexao->prepare("update usuarios set nome= ?, email = ?, senha= ?, endereco= ?, telefone= ?, dt_nascimento=? where id = ?");
            $usuario = $query->execute($array);   
            return $usuario;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

/*

/*
    function deletarUsuario($conexao, $array){
        try {
            $query = $conexao->prepare("delete from usuarios where id = ?");
            $usuario = $query->execute($array);   
             return $usuario;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }
*/    
 
 
    function listarUsuarios($conexao){
      try {
        $query = $conexao->prepare("SELECT * FROM usuarios");      
        $query->execute();
        $usuarios = $query->fetchAll();
        return $usuarios;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  

    }

/*
     function buscarUsuario($conexao,$array){
        try {
        $query = $conexao->prepare("select * from usuarios where id= ?");
        if($query->execute($array)){
            $usuario = $query->fetch(); //coloca os dados num array $usuario
            return $usuario;
        }
        else{
            return false;
        }
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
/*
    function pesquisarUsuario($conexao, $nome) {
         try {
        $query = $conexao->prepare("select * from usuarios where nome like '%$nome%'");
        if($query->execute()){
            $usuario = $query->fetchAll(); 
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

 */   


    function excluirPerfil($conexao, $array) {
        try {
            $query = $conexao->prepare("delete from usuarios where id = ?");
            $usuario = $query->execute($array);
            return $usuario;    
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function alterarPerfil($conexao, $array) {
         try {
            $query = $conexao->prepare("update usuarios set email = ?, senha= ?, foto=? where id = ?");
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

    
   ?>