<?php  
	require_once('conecta.php');
	 function inserirSala($conexao,$array){
       try {
            $query = $conexao->prepare("insert into salas (nome, descricao, nivel, nr_membros, usuario_id) values (?, ?, ?, ?, ?)");
            $result = $query->execute($array);
            return $result;
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

     function buscarSala($conexao,$array){
        try {
        $query = $conexao->prepare("select nome, descricao, nivel, nr_membros from salas where nivel = ?");
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
        $query = $conexao->prepare("select * from salas where assunto_id IN (select assunto_id from assuntos where disciplina = ?)");
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

    function editarInfomacoes($conexao, $array, $array2) {
       try {
            $query = $conexao->prepare("update salas set nome= ?, descricao = ?, nivel= ?, max_membros = ? where sala_id = ?");
            $result = $query->execute($array);
            if($result) {
                $query = $conexao->prepare("select * from assunto where assunto_id = ?");
                $result = $query->execute(array($array[5]));
                if($result->rowCount() == 1) {
                    $resultado = excluirAssunto($conexao, $array[5]);
                } 
                $result2 = inserirAssunto($conexao, $array2);
                if($result2) {
                    $resultado = colocarAssunto($conexao, $array2);
                    return $resultado;
                } else {
                    return false;
                }
            } 
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

    function excluirSala($conexao, $array){
        try {
            $query = $conexao->prepare("delete from salas where nome = ?");
            $result = $query->execute($array); 
            $result = excluirAssunto($conexao);  
            return $result;
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


?>