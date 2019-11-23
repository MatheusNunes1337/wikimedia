//funcoes referentes a logica da sala
const url_sala_user = 'includes/logica/logica_sala_user.php';
const url_sala = 'includes/logica/logica_sala.php';

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
					   <h1 class="row col-12 mb-4">Busca de salas</h1>
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
				room =	`<div class="col-12 col-xl-10 mb-5 bg-white shadow-sm rounded>
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
	let result = window.confirm("deseja mesmo sair dessa sala?");
	if(result === true) {
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
						alert(data.mensagem)
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
		alert(data.mensagem);
		window.location.href = 'buscar_salas.php';
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
		if(data.status == 'falha') {
			console.log(data.mensagem);
		} else {
			console.log(data.mensagem);
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
			alert(data.mensagem);
		} else {
			let au = window.confirm(data.mensagem);
			if(au) {
				window.location.href = 'minhas_salas.php';
			}
		}
		
	})
	.catch(err => {
		console.error(err);
	})

	event.preventDefault(); 
}

//verificada
function aceitarSolicitacao(e) {
	console.log('batata');
	let obj = new Object();
	obj.funcao = 'aceitar solicitacao';
	obj.user_id = e.target.id;
	fetch('includes/logica/logica_sala.php', {
		method: 'POST',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		if(data.status === 'sucesso') {
			alert('solicitacao aceita com sucesso');
		} else {
			alert(data.mensagem);
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
	console.log(obj);
	fetch(url_sala, {
		method: 'DELETE',
		body: JSON.stringify(obj)
	})
	.then(response => response.text())
	.then(data => {
		if(data.status == 'falha') {
			alert(data.mensagem)
		} else {
			alert('solicitacao negada com sucesso');
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
		alert(data.mensagem);
	})
	.catch(err => {
		console.error(err);
	})

	event.preventDefault(); 
}




//funcoes referentes a sala_user



function buscarPostagem() {
	let titulo = buscar.titulo.value;
	fetch(`../includes/logica/logica_sala_user.php?titulo=${titulo}`, {
		method: 'GET',
	})
	.then(response => response.json())
	.then(data => {
		if(data.status === 'sucesso') {
			let table = '<table border=1>'
	            data.forEach(obj => {
	                table += '<tr>'
	                Object.entries(obj).map(([key, value]) => {
	                    table += `<td>${value}</td>`
	                });
	                table += '</tr>';
	                resultado.innerHTML = table;
	            });
	             table += '</table>'
	           	 resultado.innerHTML = table;
	    } else {
    	     showModal(data.mensagem);
	    }    		
 	})
  	.catch(error => {
  		console.log(error);
    });
	event.preventDefault(); 
	
}

function criarPostagem() {
	let titulo = criarPost.titulo.value;
	let conteudo = criarPost.conteudo.value;
	let nomeMidia = criarPost.midia.value;
	let obj = new Object();
	obj.titulo = titulo;
	obj.conteudo = conteudo;
	obj.nomeMidia = nomeMidia;
	obj.funcao = 'criar post';
	doRequestPost(url_sala_user, obj);
}

function comentarPostagem() {
	let conteudo = comentar.conteudo.value;
	let post_id = comentar.post.value; //provavelmente terei que mudar
	let obj = new Object();
	obj.funcao = 'comentar';
	obj.conteudo = conteudo;
	obj.post_id = post_id;
	doRequestPost(url_sala_user, obj);
}

function editarPostagem(e) {
	let post_id = e.target.value;
	let titulo = editar.titulo.value;
	let conteudo = editar.conteudo.value;
	let obj = new Object();
	obj.funcao = 'editar post';
	obj.titulo = titulo;
	obj.conteudo = conteudo;
	obj.post_id = post_id;
	doRequestPut(obj);
}


function doRequestPut(url, obj) {
	fetch(url, {
		method: 'PUT',
		body: JSON.stringify(obj)
	})
	.then(response => response.text())
	.then(data => {
		console.log(data);
		/*
		if(data.status == 'falha') {
			console.log(data.mensagem)
		} else {
			console.log(data.mensagem)
		}
		*/
	})
	.catch(err => {
		console.error(err);
	})

	event.preventDefault(); 
}

function doRequestDelete(url, obj) {
	fetch(url, {
		method: 'DELETE',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		if(data.status == 'falha') {
			console.log(data.mensagem);
		} else {
			console.log(data.mensagem);
		}
		listarUsuarios();
	})
	.catch(err => {
		console.error(err);
	})
}

//funções para verificar os campos de cadastro do formulário

function verificaUsuario(e) {
	let campo = cadastro.username;
	let resultado = document.getElementsByTagName('small')[0];
	let username = e.target.value;
	if(campo.checkValidity()) {
		fetch(`../../includes/logica/logica_usuario.php?username=${username}`, {
		method: 'GET'
		})
		.then(response => response.json())
		.then(data => {
			if(data.status == 'okay') {
				resultado.style.color = 'green';
			} else {
				resultado.style.color = 'red';
			}
			resultado.innerHTML = data.mensagem;
			resultado.style.opacity = '1';
		})
		.catch(err => {
			console.error('Houve um erro ao tentar se conectar', err);
		});
	} else {
		campo.setCustomValidity('O nome de usuario deve conter de 6 a 12 caracteres');
		resultado.innerHTML = campo.validationMessage;
		resultado.style.opacity = '1';
		resultado.style.color = 'red';
	}
}

function verificaEmail(e) {
	let campo = cadastro.email;
	let resultado = document.getElementsByTagName('small')[1];
	let email = e.target.value;
	if(campo.checkValidity()) {
		fetch(`../../includes/logica/logica_usuario.php?email=${email}`, {
		method: 'GET'
		})
		.then(response => response.json())
		.then(data => {
			if(data.status == 'okay') {
			resultado.style.color = 'green';
			} else {
				resultado.style.color = 'red';
			}
			resultado.innerHTML = data.mensagem;
			resultado.style.opacity = '1';
		})
		.catch(err => {
		console.error('Houve um erro ao tentar se conectar', err);
		});
	} else {
		campo.setCustomValidity('Digite um email válido');
		resultado.innerHTML = campo.validationMessage;
		resultado.style.opacity = '1';
		resultado.style.color = 'red';
	}
}

//nao é assincrona
function verificaSenha(e) {
	let campo = cadastro.senha;
	let resultado = document.getElementsByTagName('small')[2];
	if(campo.checkValidity()) {
		resultado.innerHTML = 'Essa senha é valida';
		resultado.style.color = 'green';
	} else {
		campo.setCustomValidity('A senha deve conter de 6 a 12 caracteres');
		resultado.innerHTML = campo.validationMessage;
		resultado.style.color = 'red';
		console.log('batata');
	}
	resultado.style.opacity = '1';
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
			resultado.innerHTML = data.mensagem;
			document.getElementById('deleteRoom').className = 'btn btn-success'; //botão de deletar fica habilitado.
		} else {
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
			console.log(data.mensagem);
		}
		
	})
	.catch(err => {
		console.error(err);
	})
}

function acharUser() {
	fetch('includes/logica/logica_usuario.php?infoUser=true', {
		method: 'GET'
	})
	.then(response => response.json())
	.then(data => {
		if(data.status == 'sucesso') {
			let editarPerfil = document.getElementById('profile_config');
			editarPerfil.user_username.value = data.username;
			editarPerfil.user_email.value = data.email;
			editarPerfil.user_senha.value = data.senha;
		} else {
			console.log(data.mensagem);
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
				      		<button class="btn btn-success mb-2 mb-sm-0" onclick='banirUsuario(event)' id='${user.usuario_id}'>Banir</button>
				       		<button class="btn btn-danger" onclick='tornarAdmin(event)' id='${user.usuario_id}'>Tornar admin</button>
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
			document.getElementById('sala_solicitacoes').innerHTML += `<h2 class="text-dark mt-4">${data.mensagem}</h2>`;
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
				room = `<div class="col-12 col-xl-10 mb-5 bg-white shadow-sm rounded>
	                  	 <header class="mt-2">
	                      <h3 class="text-dark mt-3">${sala.nome}</h3>
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
			container.innerHTML += `<h2 class="text-dark">${data.mensagem}</h2>`;
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
	let obj = new Object();
	obj.username = perfilEditForm.user_username.value;
	obj.senha = perfilEditForm.user_senha.value;
	obj.email = perfilEditForm.user_email.value;
	obj.funcao = 'atualizar perfil'
	fetch('includes/logica/logica_usuario.php', {
		method: 'PUT',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		alert(data.mensagem);
	})
	.catch(err => {
		console.error(err);
	})
	event.preventDefault(); 
}

