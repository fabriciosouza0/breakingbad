<?php  

	if(isset($_SESSION['user'])) {
		if($_SESSION['user']['nome_de_usuario'] != $user['userName']) {
			header('location: /breakingbad/perfil/'.$user['userName']);
		}
	}

?>
<style type="text/css">
	main {
		margin-top: 30px;
		margin-bottom: 30px;
		background: #fff;
	}

	#cad-field {
		padding: 5px;
		height: auto;
	}

	#title {
		margin-top: 10px;
		font-size: 25px;
	}

	.float {
		position: relative;
		width: 46%;
		float: left;
		margin-left: 3.5555%;
	}

	.float tr td {
		padding: 8px;
	}

	textarea {
		outline: none;
		border: 1px solid #333;
		min-width: 392px;
		max-width: 392px;
		min-height: 122px;
		max-height: 180px;
		padding: 15px 5px;
	}

	input {
		outline: none;
		border: 1px solid #333;
		padding: 15px 5px;
		width: 392px;
	}

	.inp-text-cad:hover {
		outline: 3px solid rgba(0,0,0, 0.7);
	}

	#sub-bottom {
		margin-top: 12px;
		padding: 15px 0px;
	}

	.alert {
		height: auto;
	}
</style>

<center><h1 id="title">Editar dados do perfil</h1></center>

<form method="POST" id="cad-form" class="clear-fix" style="width: auto;">
	<div class="alert hidden" id="alert"></div>
	<table class="float">
		<tr>
			<td>Nome:</td>
		</tr>
		<tr>
			<td><input type="text" name="nome" id="nome" value="<?php echo($user['nome']); ?>" /></td>
		</tr>
		<tr>
			<td>Sobrenome:</td>
		</tr>
		<tr>
			<td><input type="text" name="sobrenome" id="sobrenome" value="<?php echo($user['sobreNome']); ?>" /></td>
		</tr>
		<tr>
			<td>Nome de usuário:</td>
		</tr>
		<tr>
			<td><input type="text" name="nome_de_usuario" id="nomeUsuario" value="<?php echo($user['userName']); ?>" /></td>
		</tr>
		<tr>
			<td>E-mail:</td>
		</tr>
		<tr>
			<td><input type="email" name="email" id="email" value="<?php echo($user['email']); ?>" /></td>
		</tr>
	</table>

	<table class="float">
		<tr>
			<td>Descrição:</td>
		</tr>
		<tr>
			<td>
				<textarea name="descricao" id="descricao"><?php echo $user['descricao']; ?></textarea>
			</td>
		</tr>
		<tr>
			<td align="center"><a href="">Deseja alterar sua senha ?</a></td>
		</tr>
	</table>
	<center>
		<input class="submit-btn-green" style="width: 80%;" type="submit" value="Alterar" id="sub-bottom" />
	</center>
</form>
<script type="text/javascript">
	let alert = $('#alert');
	$('#cad-form').submit(function(e) {
		e.preventDefault();
		let nome = $('#nome');
		let nomeUsuario = $('#nomeUsuario');
		let sobreNome = $('#sobrenome');
		let email = $('#email');
		let descricao = $('#descricao');
		let msg = '';

		if(nome.val().length == 0) {
			msg = (nome.val().length <= 45)?'Preencha o campo nome.':'O campo nome só aceita 45 caracteres.';
			nome.focus();
		}else if(sobreNome.val().length == 0) {
			msg = (nome.val().length <= 45)?'Preencha o campo sobre nome.':'O campo sobre nome só aceita 45 caracteres.';
			sobreNome.focus();
		}else if(nomeUsuario.val().length == 0) {
			msg = (nome.val().length <= 45)?'Preencha o campo nome de usuário.':'O campo nome de usuário só aceita 20 caracteres.';
			nomeUsuario.focus();
		}else if(email.val().length == 0) {
			msg = 'Preencha o campo email.';
			email.focus();
		}else if(descricao.val().length == 0) {
			msg = 'Preencha o campo descrição.';
			descricao.focus();
		}

		if(msg.length > 0) {
			if(alert.hasClass('success')) {
				alert.removeClass('success');
				alert.addClass('error');
			}else {
				alert.addClass('error');
			}

			alert.text(msg);
			alert.fadeIn('fast');

			return false;
		}

		let dados = {
			op: 3,
			nome: nome.val(),
			sobreNome: sobreNome.val(),
			nomeUsuario: nomeUsuario.val(),
			email: email.val(),
			descricao: descricao.val()
		};

		alterarPerfil(dados);
	});

	function alterarPerfil(dados) {
		console.log('entrou');
		$.post('<?=HOME?>/php/perfil_update.php', dados, function(data) {

			console.log(data['error'],data['success']);
			if(data['error'].length == 0) {
				if(alert.hasClass('error')) {
					alert.removeClass('error');
					alert.addClass('success');
				}else {
					alert.addClass('success');
				}

				alert.text(data['success']);
				alert.fadeIn('fast');

				if(data["altUser"][0]) {
					let time = 3;
					alert.text("Seu nome de usuário foi alterado, a pagina será recarregada em "+time);
					let count = setInterval(function() {
						alert.text("Seu nome de usuário foi alterado, a pagina será recarregada em "+(--time));
						if(time == 0) {
							window.location.href = '/breakingbad/perfil/'+data['altUser'][1]+'/editar';
						}
					}, 1000);
				}
			}else {
				if(alert.hasClass('success')) {
					alert.removeClass('success');
					alert.addClass('error');
				}else {
					alert.addClass('error');
				}

				alert.text(data.error);
				alert.fadeIn('fast');				
			}
			console.log(data);
		}, 'JSON');
	}
</script>