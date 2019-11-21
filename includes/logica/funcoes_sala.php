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

     function inserirAdministrador($conexao,$array){ //essa função serve para inserir o user(admin) dentro da sala após ele ter executado a função de criação.
       try {
            $query = $conexao->prepare("insert into sala_membros values (?, (select sala_id from salas where nome = ?))");
            $result = $query->execute($array);
            return $result;
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }


     function buscarSala($conexao,$array){
        try {
        $query = $conexao->prepare("select nome, descricao, nivel, max_membros,sala_id, usuarios.username 
            from salas, usuarios where salas.usuario_id = usuarios.usuario_id and 
            assunto_id IN (select assunto_id from assuntos where disciplina = ?)");
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
        $query = $conexao->prepare("select nome, descricao, nivel, max_membros, disciplina, conteudo from salas, assuntos 
            where salas.assunto_id = assuntos.assunto_id AND sala_id = ?");
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


    //lista todas as salas que o usuário logado já entrou
    function listarSalas($conexao, $array) {
         try {
            $query = $conexao->prepare("select count(sala_membros.usuario_id) as membros, nome, descricao, salas.sala_id, max_membros, nivel, conteudo, disciplina, username from salas, assuntos, usuarios, sala_membros where salas.sala_id IN (select sala_id from sala_membros where usuario_id = ?) and salas.assunto_id = assuntos.assunto_id and salas.usuario_id = usuarios.usuario_id and sala_membros.sala_id = salas.sala_id group by 
                salas.nome"); 
            if($query->execute($array)){
                $salas = $query->fetchAll(PDO::FETCH_ASSOC); 
                return $salas;
            }
            else{
                return false;
            }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }
    }

    //lista as solicitações de uma sala
    function listarSolicitacoes($conexao, $array) {
         try {
        $query = $conexao->prepare("select username, usuario_id from usuarios where usuario_id IN
            (select usuario_id from solicitacoes where sala_id = ?)"); 
        if($query->execute($array)){
            $solicitacoes = $query->fetchAll(PDO::FETCH_ASSOC); 
            return $solicitacoes;
        }
        else{
            return false;
        }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }
    }

    //lista os usuários pertencentes a sala para que eles possam ser banidos ou feitos administrador (gerência de usuários)
     function listarUsuarios($conexao, $array) {
        try {
            $query = $conexao->prepare("select username, usuario_id from usuarios where usuario_id IN
                (select usuario_id from sala_membros where sala_id = ?) and usuario_id NOT IN (select usuario_id
                from salas where sala_id = ?) order by username asc"); 
            if($query->execute($array)){
                $usuarios = $query->fetchAll(PDO::FETCH_ASSOC); 
                return $usuarios;
            }
        }catch(PDOException $e) {
           echo 'Error: ' . $e->getMessage();
        }
    }

?>