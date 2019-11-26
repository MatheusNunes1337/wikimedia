<?php
   try{
    $aux = 'mysql:host=localhost;dbname=projeto;';
    //abre a conexão com o Banco via PDO
    $conexao = new PDO($aux,'root','',
                array(
                    PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => false
                )
            );
    //echo("Conexão realizada com sucesso!<br>");
    }
catch(PDOException $ex){
    //em caso de erro mostra a mensagem
    echo("Deu erro! <br>". $ex->getMessage());
}
?>