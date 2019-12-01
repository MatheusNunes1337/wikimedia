//funcoes referentes a logica da sala
const url_sala_user = 'includes/logica/logica_sala_user.php';
const url_sala = 'includes/logica/logica_sala.php';
const postagens = document.getElementById('postagens');



let container = document.getElementById('container');
let solicitacoes = document.getElementById('sala_solicitacoes');
let t_membros = document.getElementById('table_members');
const solicitacoes_header = `
			  <h1 class="text-sm-left text-center mb-5">Solicitações</h1>
              <table class="table mt-4 col-xl-8 col-12 table-bordered" id="table_requests" style="display: none;">
                <thead class="thead-dark">
                    <tr align="center">
                      <th scope="col" class="align-middle">Imagem</th>
                      <th scope="col" class="align-middle">Nome de usuário</th>
                      <th scope="col" class="align-middle">Ações</th>
                    </tr>
                </thead>
              </table>`


//verificada
function buscarSala() {
	let disciplina = document.getElementById('search_room').value;
	fetch(`includes/logica/logica_sala.php?disciplina=${disciplina}`, {
		method: 'GET'
	})
	.then(response => response.json())
	.then(salas => {
		container.innerHTML = `
					   <h2 class="row col-12 mb-4 mt-5">Busca de salas</h2>
					   <div class="input-group bg-white mt-3 col-12 col-xl-7 mb-5 py-2  shadow-sm rounded">
	                      <input type="text" class="form-control" name="disciplina" id="search_room" placeholder="Digite a disciplina" style="height: 55px;">
	                      <span class="my-auto ml-3 input-group-btn">
	                          <button class="btn btn-success" onclick="buscarSala();" type="button">
	                              buscar
	                          </button>
	                      </span>
	                  </div>`

		if(salas.status !== 'falha') {
			var room;
			salas.forEach(sala => {
				room =	`<div class="col-12 col-xl-12 mb-5 bg-white shadow-sm rounded>
	                  	 <header class="mt-2">
	                      <h3 class="text-dark mt-3">${sala.nome}</h3>
	                    </header>
	                    <hr>
	                    <div class="room-container">
	                        <p class="text-dark text-justify">
	                          ${sala.descricao}
	                        </p>
	                    </div>
	                    <hr>
	                    <footer class="mb-2 sala d-flex flex-xl-row flex-column">
	                        <div class="mb-col-2">Disciplina: ${sala.disciplina}</div>
	                        <div class="ml-xl-4">Conteúdo: ${sala.conteudo}</div>
	                        <div class="ml-xl-4">Membros: ${sala.membros}/${sala.max_membros}</div>
	                        <div class="ml-xl-4">Nível: ${sala.nivel}</div>
	                        <div class="ml-xl-4">Dono: ${sala.username}</div>
	                    </footer>
	                    <button type="button" class="btn btn-danger my-3" id="${sala.sala_id}" onclick="enviarSolicitacao(event)">enviar solicitação</button>
	                </div>`
						
				container.innerHTML += room;
			})
			//container.innerHTML += room;
		} else {
			container.innerHTML += `<h3 class='mt-5'>${salas.mensagem} &#128546;</h3>`;
		}	
 	})
  	.catch(err => {
  		console.error('Erro ao tentar buscar uma sala', err);
    });
	event.preventDefault(); 
	
}

function deixarSala(e) {
	let obj = new Object();
	obj.funcao = 'sair sala';
	obj.sala_id = e.target.id;
	result = window.confirm('Deseja realmente sair dessa sala?');
	if(result) {
		fetch(`includes/logica/logica_usuario.php?id_sala=${obj.sala_id}&verificaUser=true`, {
			method: 'GET'
		})
		.then(response => response.json())
		.then(data => {
			if(data.status === 'okay') {
				fetch(`includes/logica/logica_sala.php`, {
					method: 'DELETE',
					body: JSON.stringify(obj)
				})
				.then(response => response.json())
				.then(data => {
					if(data.status == 'sucesso') {
						window.location.href = 'minhas_salas.php';
					} else {
						showStatus(obj.funcao, data.mensagem);
					}
				})
				.catch(err => {
					console.error(err);
				});
			} else {
				alert(data.mensagem);
			}
		})
		.catch(err => {
			console.error(err);
		});
	} else {
		console.log('você decidiu não sair da sala');
	}
}

//verificada
function enviarSolicitacao(e) {
	let obj = new Object();
	obj.funcao = 'enviar solicitacao';
	obj.sala_id = e.target.id;
	fetch(url_sala, {
		method: 'POST',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		showStatus(obj.funcao, data.mensagem);
		window.setTimeout(function() {
			window.location.href = 'buscar_salas.php';
		}, 3000);
	})
	.catch(err => {
		console.error(err);
	});

}

//verificada
function banirUsuario(e) {
	let usuario_id = e.target.id;
	let obj = new Object();
	obj.funcao = 'banir usuario';
	obj.user_id = usuario_id;
	console.log(obj);
	fetch(url_sala, {
		method: 'DELETE',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		if(data.status === 'falha') {
			showStatus(obj.funcao, data.mensagem);
		}	
		
		document.getElementById('sala_membros').innerHTML = 
		`<h1 class="text-sm-left text-center mb-5">Gerência de membros</h1>
		<table class="table mt-4 col-xl-8 col-12 table-bordered" id="table_members" style="display: none;">
                <thead class="thead-dark">
                    <tr align="center">
                      <th scope="col" class="align-middle">Imagem</th>
                      <th scope="col" class="align-middle">Nome de usuário</th>
                      <th scope="col" class="align-middle">Ações</th>
                    </tr>
                </thead>
              </table>`;
		listarUsuarios();
	})
	.catch(err => {
		console.error(err);
	})
}
//verificada
function tornarAdmin(e) {
	let confirmado = window.confirm('Concluida esta operação, você não será mais o administrador da sala. Se você está ciente disso, clique em confirmar.');
	if(confirmado) {
		let usuario_id = e.target.id;
		let obj = new Object();
		obj.funcao = 'tornar admin';
		obj.user_id = usuario_id;
		console.log(obj);
		fetch(url_sala, {
			method: 'PUT',
			body: JSON.stringify(obj)
		})
		.then(response => response.json())
		.then(data => {
			console.log(data);
			if(data.status == 'falha') {
				showStatus(obj.funcao, data.mensagem);
			} else {
					showStatus(obj.funcao, data.mensagem);
					window.setTimeout(function() {
						window.location.href = 'minhas_salas.php';
					}, 5000);		
			}	
		})
		.catch(err => {
			console.error(err);
		})
	}	

	event.preventDefault(); 
}

//verificada
function aceitarSolicitacao(e) {
	let obj = new Object();
	obj.funcao = 'aceitar solicitacao';
	obj.user_id = e.target.id;
	fetch('includes/logica/logica_sala.php', {
		method: 'POST',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		if(!data.status === 'sucesso') {
			showStatus(obj.funcao, data.mensagem);
		} 
		document.getElementById('sala_solicitacoes').innerHTML = solicitacoes_header;
		listarSolicitacoes();
	})
	.catch(err => {
		console.error(err);
	});

}
//verificada
function negarSolicitacao(e) {
	let obj = new Object();
	obj.funcao = 'negar solicitacao';
	obj.user_id = e.target.id;
	fetch(url_sala, {
		method: 'DELETE',
		body: JSON.stringify(obj)
	})
	.then(response => response.text())
	.then(data => {
		if(data.status === 'falha') {
			showStatus(obj.funcao, data.mensagem);
		} 
		document.getElementById('sala_solicitacoes').innerHTML = solicitacoes_header;
		listarSolicitacoes();
		
	})
	.catch(err => {
		console.error(err);
	})
	
}

//verificada
function editaSala() {
	let obj = new Object();
	obj.funcao = 'editar sala'
	obj.nome = formEditSala.nome.value;
	obj.descricao = formEditSala.descricao.value;
	obj.nivel = formEditSala.nivel.value;
	obj.max_membros = formEditSala.membros.value;
	obj.disciplina = formEditSala.disciplina.value;
	obj.conteudo = formEditSala.conteudo.value;
	fetch(url_sala, {
		method: 'PUT',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		showStatus(obj.funcao, data.mensagem);
	})
	.catch(err => {
		console.error(err);
	})

	event.preventDefault(); 
}




//funcoes referentes a sala_user



async function buscarPostagem() {

	postagens.innerHTML = '';
	let campo = document.getElementById('search_post');
	let content = campo.value;
	fetch(`includes/logica/logica_sala_user.php?conteudo=${content}`, {
		method: 'GET',
	})
	.then(response => response.json())
	.then(async data => {
		if(data.status !== 'vazio') {
			let post;
			for(let postagem of data) {
				post = `<article class="py-4 px-4 bg-white mb-5 shadow-sm col-xl-11" style="min-height: 155px;">
                  			<img src="includes/componentes/imagens/usuarios/${postagem.foto}" id="imagem_perfil" class="rounded-circle img-fluid" style="height: 40px;">  
                  			<span class="ml-lg-3">${postagem.username}</span>
							  <a class="py-auto pr-2 float-right dropdown-toggle btn btn-default" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							  <i class="fas fa-ellipsis-h"></i></a>
							  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item btn btn-default" href="#" onclick="oi();">Editar post</a>
									<a class="dropdown-item" btn btn-default href="#">Excluir post</a>
  							  </div>
                  			<p class="post_content text-justify mt-3">
                      			${postagem.conteudo}
                  			</p>`
                if(postagem.nm_midia !== null) {
                	post += `<div class="midia mb-3">
                    			<a href="includes/componentes/medias/outros/${postagem.nm_midia}" class="mt-3">
                    			<i class="fas fa-download text-danger" style="font-size: 1.4rem"></i></a>
                    			<span class="ml-2">${postagem.nm_midia}</span>
                  			</div>`
                									
                }

                comentarios = await listarComentarios(postagem.post_id);
                post += comentarios;
					 
    			post += `
    			  <img src="includes/componentes/imagens/usuarios/default.png" class="rounded-circle img-fluid user_img_room" style="height: 40px;">
                  <input type="text" class="form-control input_coment bg-light col-sm-9 col-md-10 col-8 d-inline ml-2" placeholder="Escreva um comentário...">
                  <button class="btn btn-default border-none float-right" onclick="comentar(event)" type="button" value="${postagem.post_id}" style="background: transparent;">
                      <i class="fas fa-paper-plane"></i>
                  </button>`;
				postagens.innerHTML += post;
			}	
			 
		} else {
			postagens.innerHTML += `<h2 class="text-dark">${data.mensagem}</h2>`;
		}	  		
 	})
  	.catch(error => {
  		console.log(error);
    });
	event.preventDefault(); 
}

function criarPostagem() {
	let funcao = 'criar post';
	let formulario = document.getElementById('post_form');
	const data = new FormData(formulario);
	data.append('criar_post', true);
	fetch(url_sala_user, {
		method: 'POST',
		body: data
	})
	.then(response => response.json())
	.then(data => {
		if(data.status == 'falha') {
			showStatus(funcao, data.mensagem);
		}
		listarPostagens();
	})
	.catch(err => {
		console.error(err);
	})
	event.preventDefault(); 
	
}


function editarPostagem(e) {
	let post_id = e.target.value;
	let conteudo = editar.conteudo.value;
	let obj = new Object();
	obj.funcao = 'editar post';
	obj.conteudo = conteudo;
	obj.post_id = post_id;
	doRequestPut(obj);
}

function deletarPostagem(e) {
	let obj = new Object();
	obj.funcao = 'deletar postagem';
	obj.id_post = e.target.value;

	fetch(url_sala_user, {
		method: 'DELETE',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		showStatus(obj.funcao, data.mensagem);
	})
	.catch(err => {
		console.error(err);
	})
}


//funções para verificar os campos de cadastro do formulário

function verificaUsuario(e) {
	let campo = cadastro.username;
	let resultado = document.getElementById('username_msg');
	let username = e.target.value;
	fetch(`includes/logica/logica_usuario.php?username=${username}`, {
		method: 'GET'
	})
	.then(response => response.json())
	.then(data => {
		if(data.status === 'okay') {
			resultado.className = 'form-text text-success';
		} else {
			resultado.className = 'form-text text-danger';
		}
		resultado.innerHTML = data.mensagem;
	})
	.catch(err => {
		console.error('Houve um erro ao tentar se conectar', err);
	});
	
}

function verificaEmail(e) {
	let campo = cadastro.email;
	let resultado = document.getElementById('email_msg');
	let email = e.target.value;
	fetch(`includes/logica/logica_usuario.php?email=${email}`, {
	method: 'GET'
	})
	.then(response => response.json())
	.then(data => {
		if(data.status === 'okay') {
			resultado.className = 'form-text text-success';
		} else {
			resultado.className = 'form-text text-danger';
		}
		resultado.innerHTML = data.mensagem;
	})
	.catch(err => {
	console.error('Houve um erro ao tentar se conectar', err);
	});

}

//nao é assincrona
function verificaSenha(e) {
	let resultado = document.getElementById('senha_msg');
	let senha = e.target.value;
	let tamanho = senha.length;
	if(tamanho < 6 || tamanho > 12) {
		resultado.innerHTML = 'A senha deve ter de 6 a 12 caracteres';
		resultado.className = 'form-text text-danger visible';
	} else {
		resultado.innerHTML = 'A senha informada é válida';
		resultado.className = 'form-text text-success visible';
	}
}

function verificaAdmPass(e) {

	let resultado = document.getElementById('pass_status');
	let senha = e.target.value;
	fetch(`includes/logica/logica_usuario.php?adminPass=${senha}`, {
	method: 'GET'
	})
	.then(response => response.json())
	.then(data => {
		if(data.status == 'okay') {
			resultado.style.color = '#28a745';
			resultado.innerHTML = data.mensagem;
			document.getElementById('deleteRoom').className = 'btn btn-success'; //botão de deletar fica habilitado.
		} else {
			resultado.style.color = '#dc3545';
			resultado.innerHTML = data.mensagem;
			document.getElementById('deleteRoom').className = 'btn btn-success disabled';
		}
		resultado.className = "form-text visible";
	})
	.catch(err => {
		console.error('Houve um erro ao tentar se conectar', err);
	});
}

     
//funções de apresentação de conteudo nas páginas. Onload

function acharSala() {
	let funcao = 'carregar informações da sala';
	fetch('includes/logica/logica_sala.php?infoSala=true', {
		method: 'GET'
	})
	.then(response => response.json())
	.then(data => {
		if(data.status == 'sucesso') {
			let editarSala = document.getElementById('editRoom');
			editarSala.nome.value = data.nome;
			editarSala.descricao.value = data.descricao;
			editarSala.nivel.value = data.nivel;
			editarSala.membros.value = data.max_membros;
			editarSala.disciplina.value = data.disciplina;
			editarSala.conteudo.value = data.conteudo;
		
		} else {
			showStatus(funcao, data.mensagem);
		}
		
	})
	.catch(err => {
		console.error(err);
	})
}

function acharUser() {
	let funcao = 'carregar informações do usuário'
	return fetch('includes/logica/logica_usuario.php?infoUser=true', {
		method: 'GET'
	})
	.then(response => response.json())
	.then(data => {
		if(data.status == 'sucesso') {
			return data;
		} else {
			showStatus(funcao, data.mensagem)	
		}
		
	})
	.catch(err => {
		console.error(err);
	})

}

function listarUsuarios() {
	fetch('includes/logica/logica_sala.php?listarUsuarios=true', {
		method: 'GET'
	})
	.then(response => response.json())
	.then(users => {
		if(users.status !== 'vazio') {
			document.getElementById('table_members').innerHTML += '<tbody id="t_corpoo"></tbody>';
			let linha;
			users.forEach(user => {
				linha = `<tr>
				      <td align="center" class="align-middle"> <img src="includes/componentes/imagens/usuarios/${user.foto}" alt="profile_image" class="img-fluid img-thumbnail rounded-circle mb-2 ml-lg-0 mt-4" style="width: 70px; height: 70px;"></td>
				      <td align="center" class="align-middle">${user.username}</td>
				      <td align="center" class="align-middle">
							   <button class="btn btn-success" onclick='tornarAdmin(event)' id='${user.usuario_id}'>Tornar admin</button>
							   <button class="btn btn-danger mb-2 mb-sm-0" onclick='banirUsuario(event)' id='${user.usuario_id}'>Banir</button>
				      </td>
				    </tr>`
				document.getElementById('t_corpoo').innerHTML += linha;	    	  
			})
			document.getElementById('table_members').style.display = 'table';					
		} else {
			document.getElementById('sala_membros').innerHTML += `<h2 class="text-dark">${users.mensagem}</h2>`;
		} 
	})
	.catch(err => {
		console.error(err);
	})
}

function listarSolicitacoes() {
	fetch('includes/logica/logica_sala.php?listarSolicitacoes=true', {
		method: 'GET'
	})
	.then(response => response.json())
	.then(data => {
		if(data.status !== 'vazio') {
			document.getElementById('table_requests').innerHTML += '<tbody id="t_corpo"></tbody>';
			let linha;
			data.forEach(solicitacao => {
				
				linha = 
				`<tr>
			      <td align="center" class="align-middle"><img src="includes/componentes/imagens/usuarios/${solicitacao.foto}" alt="profile_image" class="img-fluid img-thumbnail rounded-circle mb-2 ml-lg-0 mt-4" style="width: 70px; height: 70px;"></td>
			      <td align="center" class="align-middle">${solicitacao.username}</td>
			      <td align="center" class="align-middle">
			      		<button class="btn btn-success mb-2 mb-sm-0" id="${solicitacao.usuario_id}" onclick="aceitarSolicitacao(event);">aceitar</button>
			       		<button class="btn btn-danger" id="${solicitacao.usuario_id}" onclick="negarSolicitacao(event);">negar</button>
			      </td>
				</tr>`;  
				document.getElementById('t_corpo').innerHTML += linha;	
			})
			document.getElementById('table_requests').style.display = 'table';			
		} else {
			document.getElementById('sala_solicitacoes').innerHTML += `<h3 class="text-dark mt-4">${data.mensagem} &#128542;</h3>`;
		} 
		
	})
	.catch(err => {
		console.error(err);
	})
}

function listarSalas() {
	fetch('includes/logica/logica_sala.php?listarSalas=true', {
		method: 'GET'
	})
	.then(response => response.json())
	.then(data => {
		if(data.status !== 'vazio') {
			let room;
			data.forEach(sala => {
				room = `<div class="col-12 col-xl-12 mb-5 bg-white shadow-sm rounded>
	                  	 <header class="mt-2">
	                      <h4 class="text-dark mt-3">${sala.nome}</h4>
	                    </header>
	                    <hr>
	                    <div class="room_container mb-2 sala d-flex flex-xl-row flex-column">
	                        <div class="mb-col-2">Disciplina: ${sala.disciplina}</div>
	                        <div class="ml-xl-4">Conteudo: ${sala.conteudo}</div>
	                        <div class="ml-xl-4">Membros: ${sala.membros}/${sala.max_membros}</div>
	                        <div class="ml-xl-4">Nível: ${sala.nivel}</div>
	                        <div class="ml-xl-4">Dono: ${sala.username}</div>
	                    </div>
	                    <form  method="GET" action="includes/logica/logica_sala.php">
	                    	<button type="submit" class="btn btn-danger my-3" name="entrar_sala" value="${sala.sala_id}">Entrar</button>
	                    	<button type="button" class="btn btn-danger my-3" id="${sala.sala_id}" onclick="deixarSala(event)">Deixar sala</button>
	              
	                    </form>	
	                </div>`
				container.innerHTML += room;		  
			})					
		} else {
			container.innerHTML += `<h3 class="text-dark">${data.mensagem}</h3>`;
		} 
	})
	.catch(err => {
		console.error(err);
	})
}

function excluirConta() {
	let result = window.confirm('Deseja mesmo excluir a sua conta?');
	if(result) {
		let obj = new Object();
		obj.funcao = 'excluir conta'
		fetch('includes/logica/logica_usuario.php', {
			method: 'DELETE',
			body: JSON.stringify(obj)
		})
		.then(response => response.json())
		.then(data => {
			if(data.status == 'sucesso') {
				window.location.href = 'login.php'
			} else {
				alert(data.mensagem);
			}
			console.log(data);	
		})
		.catch(err => {
			console.error(err);
		})
	} 
}


function editarConta() {
	let funcao = 'configurar conta';
	let formulario = document.getElementById('profile_config');
	const data = new FormData(formulario);
	data.append('atualizar_perfil', true);
	fetch('includes/logica/logica_usuario.php', {
		method: 'POST',
		body: data
	})
	.then(response => response.json())
	.then(data => {
		showStatus(funcao, data.mensagem)
		putUserInfo();
	})
	.catch(err => {
		console.error(err);
	})
	event.preventDefault(); 
}

function showStatus(title, msg) {
	document.getElementById('status_titulo').innerHTML = title;
	document.getElementById('status_content').innerHTML = msg;
	$('#modal_status').modal();
}

function showConfirm(title, msg) {
	document.getElementById('confirm_titulo').innerHTML = title;
	document.getElementById('confirm_content').innerHTML = msg;
	$('#modal_confirm').modal();
}



async function listarPostagens() {
	let a;
	let comentarios;
	postagens.innerHTML = '';
	fetch('includes/logica/logica_sala_user.php?listarPostagens=true', {
		method: 'GET'
	})
	.then(response => response.json())
	.then(async data => {
		if(data.status !== 'vazio') {
			let post;
			for(let postagem of data) {
				post = `<article class="py-4 px-4 bg-white mb-5 shadow-sm col-xl-11" style="min-height: 155px;">
                  			<img src="includes/componentes/imagens/usuarios/${postagem.foto}" id="imagem_perfil" class="rounded-circle img-fluid" style="height: 40px;">  
                  			<span class="ml-lg-3">${postagem.username}</span>
							  <a class="py-auto pr-2 float-right dropdown-toggle btn btn-default" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							  <i class="fas fa-ellipsis-h"></i></a>
							  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item btn btn-default" href="#" onclick="oi();">Editar post</a>
									<a class="dropdown-item" btn btn-default href="#">Excluir post</a>
  							  </div>
                  			<p class="post_content text-justify mt-3">
                      			${postagem.conteudo}
                  			</p>`
                if(postagem.nm_midia !== null) {
                	post += `<div class="midia mb-3">
                    			<a href="includes/componentes/medias/outros/${postagem.nm_midia}" class="mt-3">
                    			<i class="fas fa-download text-danger" style="font-size: 1.4rem"></i></a>
                    			<span class="ml-2">${postagem.nm_midia}</span>
                  			</div>`
                									
                }

                comentarios = await listarComentarios(postagem.post_id);
                post += comentarios;
					 
    			post += `
    			  <img src="includes/componentes/imagens/usuarios/default.png" class="rounded-circle img-fluid user_img_room" style="height: 40px;">
                  <input type="text" class="form-control input_coment bg-light col-sm-9 col-md-10 col-8 d-inline ml-2" placeholder="Escreva um comentário...">
                  <button class="btn btn-default border-none float-right" value="${postagem.post_id}" onclick="comentar(event)" type="button" style="background: transparent;">
                      <i class="fas fa-paper-plane"></i>
                  </button>`;
                postagens.innerHTML += post;

            }    
		} else {
			container.innerHTML += `<h3 class="text-dark">${data.mensagem}</h3>`;
		}
	})
	.catch(err => {
		console.error(err);
	})	
	
}
	
		

//async function listartMensagens();

async function listarComentarios(post_id) {

	return fetch(`includes/logica/logica_sala_user.php?listarComentarios=true&post_id=${post_id}`, {
		method: 'GET'
	})
	.then(response => response.json())
	.then(data => {
		if(data.status !== 'vazio') {
			let comentario;
			let comentarios;
			comentarios = '<div class="comentarios mt-5">'
			data.forEach(comentario => {
			coment = `<div class="comentario mb-4">
                        <img src="includes/componentes/imagens/usuarios/${comentario.foto}" class="rounded-circle img-fluid p_image" style="height: 40px;">  
                        <span class="ml-lg-2 text-danger">${comentario.username}:</span>
                        <span class="coment_content bg-light px-3 rounded">${comentario.conteudo}</span>    
                      </div>`
			comentarios += coment;	
			})
			comentarios += '</div>'
			return comentarios;
		} else {
			return '';
		} 
	})
	.catch(err => {
		console.error(err);
	})	

}





//funcão de carregamento de informação do usuário na tela;
function putUserInfo() {
	let userInfo = acharUser(); 
	let current_url = document.URL;
	if(current_url === "http://localhost/wikimedia/perfil_config.php") {
		userInfo.then(user => {
		let editarPerfil = document.getElementById('profile_config');
			editarPerfil.user_username.value = user.username;
			editarPerfil.user_email.value = user.email;
			editarPerfil.user_senha.value = user.senha;
			document.getElementById('user_image').src = `includes/componentes/imagens/usuarios/${user.foto}`;
			document.getElementById('imagem_perfil').src = `includes/componentes/imagens/usuarios/${user.foto}`;
			document.getElementById('img_user').src = `includes/componentes/imagens/usuarios/${user.foto}`;
			document.getElementById('nome_usuario').innerHTML = user.username;
			document.getElementById('nome_user').innerHTML = user.username;
		});
	} else if(current_url === "http://localhost/wikimedia/sala.php") {
		userInfo.then(user => {
			document.getElementById('user_sala_nome').innerHTML = user.username;
			document.getElementById('user_sala_img').src = `includes/componentes/imagens/usuarios/${user.foto}`;
			document.getElementById('imagem_perfil').src = `includes/componentes/imagens/usuarios/${user.foto}`;
			document.getElementById('nome_usuario').innerHTML = user.username;
			document.getElementById('nome_user').innerHTML = user.username;
			document.getElementById('img_user').src = `includes/componentes/imagens/usuarios/${user.foto}`;
			//document.querySelectorAll('.user_img_room').src = `includes/componentes/imagens/usuarios/${user.foto}`;
		});	
	} else {
		userInfo.then(user => {
			document.getElementById('nome_usuario').innerHTML = user.username;
			document.getElementById('nome_user').innerHTML = user.username;
			document.getElementById('imagem_perfil').src = `includes/componentes/imagens/usuarios/${user.foto}`;
			document.getElementById('img_user').src = `includes/componentes/imagens/usuarios/${user.foto}`;
		});
	}
}

	
