//funcoes referentes a logica da sala

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
	fetch('../includes/logica/logica_sala.php', {
		method: 'POST'
		body: JSON.stringify(obj);
	})
	.then(response => response.json())
	.then(data => {
		//chama a modal e escreve nela
		showModal(data.mensagem);
	})
	.catch(error => {
		console.log(error);
	});

}

function banirUsuario(e) {
	let usuario_id = e.target.value;
	let obj = new Object();
	obj.funcao = 'banir usuario';
	obj.userId = usuario_id;
	fetch('../includes/logica/logica_sala.php', {
		method: 'DELETE',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		showModal(data.mensagem);
	})
	.catch(error => {
		console.error(error);
	});

}

function tornarAdmin(e) {
	let usuario_id = e.target.value;
	let obj = new Object();
	obj.funcao = 'tornar admin';
	obj.user_id = usuario_id;
	fetch('../includes/logica/logica_sala.php', {
		method: 'PUT',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		showModal(data.mensagem);
	})
	.catch(error => {
		console.error(error);
	});
}

function aceitarSolicitacao(e) {
	let usuario_id = e.target.value;
	let obj = new Object();
	obj.funcao = 'aceitar solicitacao';
	obj.user_id = usuario_id;
	fetch('../includes/logica/logica_sala.php', {
		method: 'POST',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		if(data.status === 'falha') {
			showModal(data.mensagem);
		}
	})
	.catch(error => {
		console.error(error);
	});

}

function negarSolicitacao(e) {
	let usuario_id = e.target.value;
	let obj = new Object();
	obj.funcao = 'negar solicitacao';
	obj.user_id = usuario_id;
	fetch('../includes/logica/logica_sala.php', {
		method: 'DELETE',
		body: JSON.stringify(obj)
	})
	.then(response => response.json())
	.then(data => {
		if(data.status === 'falha') {
			showModal(data.mensagem);
		}
	})
	.catch(error => {
		console.error(error);
	});

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

}