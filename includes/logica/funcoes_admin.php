<?php
    require_once('conecta.php');
    require_once('funcoes_sala.php');

   function aceitarSolicitacao($conexao,$array){
       try {
            $query = $conexao->prepare("insert into sala_membros (usuario_id, sala_id) values (?, ?)");
            $result1 = $query->execute($array);
            if($result1) {
                $result2 = negarSolicitacao($conexao, $array);
                if($result2) {
                    return $result2;
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

    function negarSolicitacao($conexao, $array) {
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
            $query = $conexao->prepare("delete from sala_membros where usuario_id = ? AND sala_id = ?");
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

     function editarInformacoes($conexao, $array, $array2) {
       try {
            $query = $conexao->prepare("update salas set nome= ?, descricao = ?, nivel= ?, max_membros = ? where sala_id = ?");
            $result = $query->execute($array);
            if($result) {
                $result = verificaAssunto($conexao, array($array2[0], $array2[1])); //verifica se o assunto ja existe.
                if(!$result) {// Se sim, faz com que a sala receba o id desse assunto.
                     $query = $conexao->prepare("update salas set assunto_id = (select assunto_id from assuntos where conteudo = ?
                        and disciplina = ?) where nome = ?");
                     $resultado = $query->execute($array2);
                     $resultado = excluirAssunto($conexao); //exclui os assuntos que nao possuem sala.
                     return $resultado;
                } else {// Caso contrario, cria um novo assunto e atribui esse assunto novo para a sala atualizada.
                    $result2 = inserirAssunto($conexao, array($array2[0], $array2[1]));
                    $resultado = colocarAssunto($conexao, $array2);
                    $resultado = excluirAssunto($conexao); //exclui os assuntos que nao possuem sala.
                    return $resultado;
                }    
            } 
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    
   ?>