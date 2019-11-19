//funcoes referentes a logica da sala
const url_sala_user = 'includes/logica/logica_sala_user.php';
const url_sala = 'includes/logica/logica_sala.php';

let container = document.getElementById('container');
let t_solicitacoes = document.getElementById('table_requests');

//verificada
function buscarSala() {
	let disciplina = document.getElementById('search_room').value;
	fetch(`includes/logica/logica_sala.php?disciplina=${disciplina}`, {
		method: 'GET'
	})
	.then(response => response.json())
	.then(salas => {
		console.log(salas);
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
				room =	`<div class="col-12 mb-5 bg-white shadow-sm rounded>
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
	                        <div class="mb-col-2">Disciplina: Matemática</div>
	                        <div class="ml-xl-4">Assunto: Trigonometria</div>
	                        <div class="ml-xl-4">Membros: 19/${sala.max_membros}</div>
	                        <div class="ml-xl-4">Nível: ${sala.nivel}</div>
	                        <div class="ml-xl-4">Dono: ${sala.username}</div>
	                    </footer>
	                    <button type="button" class="btn btn-danger my-3" onclick="enviarSolicitacao(event)">enviar solicitação</button>
	                </div>`
						
				container.innerHTML += room;
			})
			//container.innerHTML += room;
		} else {
			console.log(salas.mensagem)
			container.innerHTML += `<h3 class='mt-5'>${salas.mensagem} &#128546;</h3>`;
		}	
 	})
  	.catch(err => {
  		console.error('Erro ao tentar buscar uma sala', err);
    });
	event.preventDefault(); 
	
}

//verificada
function enviarSolicitacao(e) {
	let obj = new Object();
	obj.funcao = 'enviar solicitacao';
	obj.sala_id = e.target.id;
	//doRequestPost(url_sala, obj);
	fetch(url_sala, {
		method: 'POST',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		if(data.status == 'sucesso') {
			let botao = document.getElementById(obj.sala_id).permDisabled = true;
		}
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
	doRequestDelete(url_sala, obj);
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

//verificada
function aceitarSolicitacao(e) {
	console.log('batata');
	let obj = new Object();
	obj.funcao = 'aceitar solicitacao';
	obj.user_id = e.target.id;
	console.log(obj);
	fetch('includes/logica/logica_sala.php', {
		method: 'POST',
		body: JSON.stringify(obj)
	})
	.then(response => response.text())
	.then(data => {
		console.log(data);
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
	.then(response => response.json())
	.then(data => {
		if(data.status == 'falha') {
			console.log(data.mensagem)
		}
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
	obj.nome = editarSala.nome.value;
	obj.descricao = editarSala.descricao.value;
	obj.nivel = editarSala.nivel.value;
	obj.max_membros = editarSala.membros.value;
	obj.disciplina = editarSala.disciplina.value;
	obj.conteudo = editarSala.conteudo.value;
	fetch(url_sala, {
		method: 'PUT',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		console.log(data.mensagem);
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

     
//funções de apresentação de conteudo nas páginas. Onload

function acharSala() {
	fetch('includes/logica/logica_sala.php?infoSala=true', {
		method: 'GET'
	})
	.then(response => response.json())
	.then(data => {
		if(data.status == 'sucesso') {
			let editarSala = document.getElementsByTagName('form')[0];
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

function listarUsuarios() {
	fetch('includes/logica/logica_sala.php?listarUsuarios=true', {
		method: 'GET'
	})
	.then(response => response.json())
	.then(users => {
		if(users.status !== 'vazio') {
			let usuarios = '<h1>Gerencia de usuários</h1>'
			usuarios += '<article>'
			users.forEach(user => {
				usuarios += `<div class='user'>
							<p>${user.username}</p>
							<button onclick='banirUsuario(event)' id='${user.usuario_id}'>Banir</button>
							<button onclick='tornarAdmin(event)' id='${user.usuario_id}'>Tornar administrador</button>
						  </div>`
				document.getElementsByClassName('usuarios')[0].innerHTML = usuarios;		  
			})
			usuarios += '</article>'
			document.getElementsByClassName('usuarios')[0].innerHTML = usuarios;
								
		} else {
			document.getElementsByClassName('usuarios')[0].innerHTML = `<p>${users.mensagem}</p>`;
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
			t_solicitacoes = `<table class="table mt-4 col-xl-auto col-sm-12 table-responsive" id="table_requests">
           			<thead class="thead-dark">
					    <tr align="center">
					      <th scope="col" class="align-middle">Imagem</th>
					      <th scope="col" class="align-middle">Nome de usuário</th>
					      <th scope="col" class="align-middle">Ações</th>
					    </tr>
  					</thead>`;
			let linhas;
			data.forEach(solicitacao => {
				linhas += `<tr>
				      <td align="center" class="align-middle"> <img src="includes/componentes/imagens/usuarios/matheus.jpg" alt="profile_image" class="img-fluid img-thumbnail rounded-circle mb-2 ml-lg-0 mt-4" style="width: 70px; height: 70px;"></td>
				      <td align="center" class="align-middle">Matheus Nunes</td>
				      <td align="center" class="align-middle">
				      		<button class="btn btn-success mb-2 mb-sm-0" onclick="aceitarSolicitacao(event);">aceitar</button>
				       	<button class="btn btn-danger" onclick="negarSolicitacao(event);>negar</button>
				      </td>
				    </tr>`
				document.getElementsByClassName('solicitacoes')[0].innerHTML = solicitacoes;		  
			})
			t_solicitacoes += linhas;
			t_solicitacoes += '</table>';					
		} else {
			t_solicitacoes += `<h2 class="text-dark">${data.mensagem}</h2>`;
		} 
		
	})
	.catch(err => {
		console.error(err);
	})
}	       
