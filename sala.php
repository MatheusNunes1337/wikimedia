<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <?php require_once('includes/componentes/cabecalho.php') ?>
  <title>Feed</title>
</head>
<body class="container-fluid bg-light">
    <?php require_once('includes/componentes/nav.php') ?>
    <div class="row" id="tchau">
      <?php require_once('includes/componentes/aside.php') ?>
      <main class="container-fluid col-xl-10 py-5 col-lg-9 col-12 bg-light">
           <content class="d-flex flex-column container-fluid py-5 row col-11 mx-auto" id="container" style="min-height: auto;">
           		<div class="input-group bg-white mt-3 col-12 col-xl-7 mb-5 py-2  shadow-sm rounded">
                  <input type="text" class="form-control" name="postagem" id="search_post" placeholder="Buscar postagem" style="height: 55px;">
                  <span class="my-auto ml-3 input-group-btn">
                      <button class="btn btn-success" onclick="buscarSala();" type="button">
                          buscar
                      </button>
                  </span>
              </div>
              <div class="d-flex align-items-center">
                <img src="" id="imagem_perfil" class="img-thumbnail rounded-circle" style="width: 60px; height: 60px;">
                <span class="ml-3">Matheus Nunes</span>
              </div>
              <form class="form-group mt-3 col-12 col-xl-7 mb-5 py-2" id="post_form" onsubmit="criarPostagem();">
                  <textarea class="form-control bg-white" rows="4" maxlength="800" style="min-width: 100%" name="post_text" placeholder="O wikimedia é mais divertido quando coisas são compartilhadas"></textarea>
                  <button type="submit" class="btn btn-danger mt-2">Publicar</button>
                  <span class="btn btn-file mt-2" style="background: #0b1a21;">
                      <i class="fas fa-file-word text-white" style="font-size: 22px;"></i> <input type="file" name="post_media">
                  </span>
              </form>
              <section class="mt-3 col-12 col-xl-8 mb-5 py-2" style="min-height: 800px;">
                  <article class="py-3 px-2 bg-white mb-5 shadow-sm">
                    <div class="d-flex align-items-center px-4">
                      <picture class="row col-3 col-xl-1">
                          <img src=".." id="imagem_perfil" class="rounded-circle img-fluid" style="height: 40px;">
                      </picture>
                      <span class="ml-3">Matheus Nunes</span>
                  </div>
                  <p class="mt-3 text-justify px-4">
                      Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

                      The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.  
                  </p>
                  <a href="includes/componentes/medias/outros/Inglês_1-Certificado_digital_61086.pdf" class="mt-3 px-4"><i class="fas fa-download text-danger" style="font-size: 1.4rem"></i></a><span class="ml-1">Inglês_1-Certificado_digital_61086.pdf</span>
                  <div class="d-flex mt-5 px-4">
                    <picture class="row col-4 col-xl-1">
                        <img src=".." id="imagem_perfil" class="rounded-circle img-fluid" style="height: 40px;">
                    </picture>
                    <span class="bg-light ml-2 rounded col-8 col-xl-11">Matheus Nunes: Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable. passage, and going through the cites of the word in classical literature, discovered the undoubtable</span>
                  </div>
                  <form class="form-inline px-4 pb-4">
                      <picture class="row col-4 col-xl-1 mt-5">
                          <img src=".." id="imagem_perfil" class="rounded-circle img-fluid" style="height: 40px;">
                      </picture>
                      <div class="form-group ml-lg-1 col-8 col-xl-11 mt-5">
                          <input type="text" class="form-control input_coment col-12 bg-light" placeholder="Escreva um comentário...">
                      </div>  
                  </form>  
                  </article>
                  <article class="py-3 px-2 bg-white mb-5 shadow-sm">
                    <div class="d-flex align-items-center px-4">
                      <picture class="row col-3 col-xl-1">
                          <img src=".." id="imagem_perfil" class="rounded-circle img-fluid" style="height: 40px;">
                      </picture>
                      <span class="ml-3">Matheus Nunes</span>
                  </div>
                  <p class="mt-3 text-justify px-4">
                      Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

                      The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.  
                  </p>
                  <div class="col-7 bg-success ml-4" style="min-height: 700px;"></div>
                  <div class="d-flex mt-5 px-4">
                    <picture class="row col-4 col-xl-1">
                        <img src=".." id="imagem_perfil" class="rounded-circle img-fluid" style="height: 40px;">
                    </picture>
                    <span class="bg-light ml-2 rounded col-8 col-xl-11">Matheus Nunes: Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable. passage, and going through the cites of the word in classical literature, discovered the undoubtable</span>
                  </div>
                  <form class="form-inline px-4 pb-4">
                      <picture class="row col-4 col-xl-1 mt-5">
                          <img src=".." id="imagem_perfil" class="rounded-circle img-fluid" style="height: 40px;">
                      </picture>
                      <div class="form-group ml-lg-1 col-8 col-xl-11 mt-5">
                          <input type="text" class="form-control input_coment col-12 bg-light" placeholder="Escreva um comentário...">
                      </div>  
                  </form>  
                  </article>
              </section> 
           </content>  
      </main>
    </div>
    <?php require_once('includes/componentes/modais.php') ?> 
    <?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>







