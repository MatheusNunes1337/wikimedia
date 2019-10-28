<?php  
	require_once('conecta.php');
	 function criarSala($conexao,$array){
       try {
            $query = $conexao->prepare("insert into salas (nome, descricao, nivel, max_membros, usuario_id) values (?, ?, ?, ?, ?)");
            $result = $query->execute($array);
            return $result;
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

     function buscarSala($conexao,$array){
        try {
        $query = $conexao->prepare("select * from salas where assunto_id IN (select assunto_id from assuntos where disciplina = ?)");
        if($query->execute($array)){
            $sala = $query->fetchAll(PDO::FETCH_ASSOC); //coloca os dados num array $usuario
            return $sala;
        }
        else{
            return false;
        }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
    }

     function acharSala($conexao,$array){
        try {
        $query = $conexao->prepare("select * from salas where nome= ?");
        if($query->execute($array)){
            $sala = $query->fetch(PDO::FETCH_ASSOC); 
            return $sala;
        }
        else{
            return false;
        }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
    }



     function inserirAssunto($conexao,$array){ //insere na tabela de assuntos o assunto digitado no formulario
       try {
            $query = $conexao->prepare("insert into assuntos (conteudo, disciplina) values (?, ?)");
            $result = $query->execute($array);
            return $result;
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

    function colocarAssunto($conexao, $array) { //coloca o assunto na tabela de salas
         try {
            $query = $conexao->prepare("update salas set assunto_id = (select assunto_id from assuntos where conteudo = ? and disciplina = ?) where 
                nome = ?");
            $result = $query->execute($array);
            return $result;
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function excluirAssunto($conexao) {
         try {
            $query = $conexao->prepare("delete from assuntos where assunto_id not in (select assunto_id from salas)");
            $result = $query->execute();   
             return $result;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function verificaAssunto($conexao, $array) {
        try {
            $query = $conexao->prepare("select * from assuntos where conteudo = ? and disciplina = ?");
            if($query->execute($array)){
                $query->fetch();
                if($query->rowCount() < 1) {
                    $info = true;
                } else {
                    $info = false;
                }
                return $info;
            }
            else{
                return false;
            }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
    }

    function enviarSolicitacao($conexao, $array) {
         try {
            $query = $conexao->prepare("insert into solicitacoes (usuario_id, sala_id) values (?, ?)");
            $result = $query->execute($array);
            return $result;
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function sairSala($conexao, $array) {
        try {
            $query = $conexao->prepare("delete from sala_membros where usuario_id = ?");
            $result = $query->execute($array);   
             return $result;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }



?>