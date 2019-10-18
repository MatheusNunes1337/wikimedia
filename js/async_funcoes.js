//funcoes referentes a logica da sala
const url_sala_user = '../includes/logica/logica_sala_user.php';
const url_sala = '../includes/logica/logica_sala.php';

function buscarSala() {
	let disciplina = buscar.disciplina.value;
	fetch(`../includes/logica/logica_sala.php?disciplina=${disciplina}`, {
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

function enviarSolicitacao() {
 
	let obj = new Object();
	obj.funcao = 'enviar solicitacao';
	doRequestPost(url_sala, obj);

}

function banirUsuario(e) {
	let usuario_id = e.target.value;
	let obj = new Object();
	obj.funcao = 'banir usuario';
	obj.userId = usuario_id;
	doRequestDelete(url_sala, obj);
}

function tornarAdmin(e) {
	let usuario_id = e.target.value;
	let obj = new Object();
	obj.funcao = 'tornar admin';
	obj.user_id = usuario_id;
	doRequestPut(url_sala, obj);
}

function aceitarSolicitacao(e) {
	let usuario_id = e.target.value;
	let obj = new Object();
	obj.funcao = 'aceitar solicitacao';
	obj.user_id = usuario_id;
	doRequestPost(url_sala, obj);
}

function negarSolicitacao(e) {
	let usuario_id = e.target.value;
	let obj = new Object();
	obj.funcao = 'negar solicitacao';
	obj.user_id = usuario_id;
	doRequestDelete(url_sala, obj);
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







function doRequestPost(url, obj) {
	fetch(url, {
		method: 'POST',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		if(data.status == 'falha') {
			showModal(data.mensagem);
		}
	})
	.catch(error) {
		console.error(error);
	}
}

function doRequestPut(url, obj) {
	fetch(url, {
		method: 'PUT',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		if(data.status == 'falha') {
			showModal(data.mensagem);
		}
	})
	.catch(error) {
		console.error(error);
	}
}

function doRequestDelete(url, obj) {
	fetch(url, {
		method: 'DELETE',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		if(data.status == 'falha') {
			showModal(data.mensagem);
		}
	})
	.catch(error) {
		console.error(error);
	}
}

