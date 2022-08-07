<!DOCTYPE html>
<html>
<head>
	<?php include_once('../php/config.php') ?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no" />
	<meta name="description" content="Site de notícias sobre Breaking Bad - Cadastro" />
	<meta name="keywords" content="Breaking Bad, Cadastro" />
	<meta name="robots" content="index, follow" />
	<meta name="author" content="Fabricio Souza" />
	<link rel="icon" href="<?=HOME?>/logo.ico" type="image/x-icon" />
	<title>Breaking Bad - Cadastro</title>
	<link rel="stylesheet" type="text/css" href="<?=HOME?>/css/style.css" />
	<script type="text/javascript" src="<?=HOME?>/js/jquery.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#cad-form').submit(function(e) {
				e.preventDefault();

				let nome = $('#nome');
				let nomeUsuario = $('#nomeUsuario');
				let sobreNome = $('#sobreNome');
				let email = $('#email');
				let senha = $('#senha');
				let message = $('#alert');
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
				}else if(senha.val().length == 0) {
					msg = 'Preencha o campo senha.';
					senha.focus();
				}

				if(msg.length > 0) {
					if(message.hasClass("success")){
						message.removeClass("success");
						message.addClass("error");
					}else {
						message.addClass("error");
					}
					message.text(msg);
					message.fadeIn('fast');

					return false;
				}

				let dados = {
					nomeUsuario: nomeUsuario.val(),
					nome: nome.val(),
					sobreNome: sobreNome.val(),
					email: email.val(),
					senha: senha.val()
				};

				cadastrarUsuario(dados);
			});

			function redireciona (data) {
				window.location.href = '/breakingbad/perfil/'+data;
			}

			function cadastrarUsuario(dados) {
				$.ajax({
					type: "POST",
					url: "../php/cad_usuario.php",
					data: dados,

					error: function (xhr, status, error) {
						console.log(xhr, status, error);
					},

					success: function (data) {
						let message = $('#alert');

						if(data.erro.length > 0) {
							message.text(data.erro);

							if(message.hasClass("success")){
								message.removeClass("success");
								message.addClass("error");
							}else {
								message.addClass("error");
							}

							message.fadeIn('fast');
						}else {

							if(message.hasClass("error")){
								message.removeClass("error");
								message.addClass("success");	
							}else {
								message.addClass("success");
							}

							message.fadeIn('fast');

							let time = 5;
							message.text(data.sucesso+" redirecionando em "+time);
							let interval = setInterval(function () {
								message.text(data.sucesso+(--time));
								if(time == 0) {
									redireciona(data.userName);
									clearInterval(interval);
								}
							}, 1000);

						}

					},

					dataType: "JSON"

				});
			}
		});
	</script>
	<style type="text/css">
		@media screen and (max-width: 480px){
			.alert {
				width: 88%;
			}
		}
	</style>
</head>
<body id="cad-body">
<form id="cad-form" method="post">
	<fieldset id="cad-field">
		<div class="alert hidden" id="alert"></div>
		<legend style="text-align: center; padding: 0px 10px;"><img src="<?=HOME?>/assets/cadeado.png" width="40px;" height="40px;" draggable="false" /></legend>
		<table style="position: relative; margin: 0 auto;">
			<tr>
				<td><input type="text" name="nome" id="nome" class="inp-text-cad" placeholder="Nome" /></td>
			</tr>
			<tr>
				<td><input type="text" name="sobreNome" id="sobreNome" class="inp-text-cad" placeholder="Sobrenome" /></td>
			</tr>
			<tr>
				<td><input type="text" name="nomeUsuario" id="nomeUsuario" class="inp-text-cad" placeholder="Nome de Usuário" /></td>
			</tr>
			<tr>
				<td><input type="email" name="email" id="email" class="inp-text-cad" placeholder="E-mail" /></td>
			</tr>
			<tr>
				<td><input type="password" name="senha" id="senha" class="inp-text-cad" placeholder="Senha" /></td>
			</tr>
			<tr>
				<td><input type="submit" name="" value="Cadastrar-se" /></td>
			</tr>
		</table>
	</fieldset>
</form>
</body>
</html>