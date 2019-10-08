<?php
 
    function aceitarSolicitacoes($conexao,$array){
       try {
            $query = $conexao->prepare("insert into sala_membros (usuario_id, sala_id) values (?, ?)");
            $result1 = $query->execute($array);
            if($result1) {
                $result2 = negarSolicitacoes($conexao, $array);
                if($result2) {
                    return $usuario;
                } else {
                    return false;
                }
            } else {
                return false;
            } 
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

    function negarSolicitacoes($conexao, $array) {
         try {
            $query = $conexao->prepare("delete from solicitacoes where usuario_id = ? and sala_id = ?");
            $result = $query->execute($array);
            return $result;    
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function banirUsuario($conexao, $array) {
         try {
            $query = $conexao->prepare("delete from sala_membros where usuario_id = ?");
            $result = $query->execute($array);
            return $result;    
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    function tornarAdministrador($conexao, $array) {
        try {
            $query = $conexao->prepare("update salas set usuario_id = ? where sala_id = ?");
            $result = $query->execute($array);   
            return $result;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
   ?>