//funcoes referentes a logica da sala
const url_sala_user = 'includes/logica/logica_sala_user.php';
const url_sala = 'includes/logica/logica_sala.php';

let container = document.getElementsByTagName('section')[0];

//verificada
function buscarSala() {
	let disciplina = buscar.disciplina.value;
	container.innerHTML = '';
	fetch(`includes/logica/logica_sala.php?disciplina=${disciplina}`, {
		method: 'GET'
	})
	.then(response => response.json())
	.then(salas => {
		let room = '<article>'
		salas.forEach(sala => {
			room += `<div>
						<h2>${sala.nome}</h2>
						<p>${sala.descricao}</p>
						<button id=${sala.sala_id} onclick='enviarSolicitacao(event)'>Ingressar</button>
					</div>`
			container.innerHTML = room;
		})
		room += '</article>';	
		container.innerHTML = room;
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

function banirUsuario(e) {
	let usuario_id = e.target.id;
	let obj = new Object();
	obj.funcao = 'banir usuario';
	obj.user_id = usuario_id;
	console.log(obj);
	doRequestDelete(url_sala, obj);
}

function tornarAdmin(e) {
	let usuario_id = e.target.id;
	let obj = new Object();
	obj.funcao = 'tornar admin';
	obj.user_id = usuario_id;
	console.log(obj);
	doRequestPut(url_sala, obj);
}

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
	})
	.catch(err => {
		console.error(err);
	});
}

function negarSolicitacao(e) {
	let obj = new Object();
	obj.funcao = 'negar solicitacao';
	obj.user_id = e.target.id;
	console.log(obj);
	fetch(url_sala, {
		method: 'DELETE',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		if(data.status == 'falha') {
			console.log(data.mensagem)
		}
	})
	.catch(err => {
		console.error(err);
	})
	
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
		if(data.status == 'falha') {
			console.log(data.mensagem)
		} else {
			console.log(data.mensagem)
		}
	})
	.catch(err => {
		console.error(err);
	})
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
     

	       
