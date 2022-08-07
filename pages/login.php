<!DOCTYPE html>
<html>
<head>
	<?php include ('../php/config.php'); ?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no" />
	<meta name="description" content="Site de notícias sobre Breaking Bad - Cadastro" />
	<meta name="keywords" content="Breaking Bad, Cadastro" />
	<meta name="robots" content="index, follow" />
	<meta name="author" content="Fabricio Souza" />
	<link rel="icon" href="<?=HOME?>/logo.ico" type="image/x-icon" />
	<title>Breaking Bad - Cadastro</title>
	<link rel="stylesheet" type="text/css" href="<?=STYLE?>" />
	<script type="text/javascript" src="<?=HOME?>/js/jquery.js"></script>
	<script type="text/javascript">
		let blocked = false;
		$(function() {

			$('#cad-form').submit(function(e) {
				e.preventDefault();
				let email = $('#email');
				let senha = $('#senha');
				let alert = $('#alert');
				let msg = '';

			 	if(email.val().length == 0) {
			 		msg = 'Preencha o campo e-mail.';
					email.focus();
				}else if(senha.val().length == 0) {
					msg = 'Preencha o campo senha.';
					senha.focus();
				}

				if(msg.length > 0) {
					alert.fadeIn('fast');

					if(alert.hasClass('success')) {
						alert.removeClass('success');
						alert.addClass('error');
					}else {
						alert.addClass('error');
					}

					alert.text(msg);

					return false;	
				}

				let dados = {
					email: email.val(),
					senha: senha.val()
				};

				login(dados);			
			});

			function login(dados) {
				$.post('../php/login.php', dados, function(data) {
					let alert = $('#alert');

					if(data.error.length == 0){
						if(alert.hasClass('error')) {
							alert.removeClass('error');
							alert.addClass('success');
						}else {
							alert.addClass('success');
						}

						let time = 5;
						alert.text(data.success+" Você será redirecionado em "+ time);
						alert.fadeIn('fast');

						let interval = setInterval(function() {
							alert.text(data.success+" Você será redirecionado em "+(--time));

							if(time == 0) {
								window.location.href = '/breakingbad/perfil/'+data.userName;
								clearInterval(interval);
							}

						}, 1000);
					}else {
						if(alert.hasClass('success')) {
							alert.removeClass('success');
							alert.addClass('error');
						}else {
							alert.addClass('error');
						}

						alert.fadeIn('fast');

						alert.text(data.error);
					}

				}, 'JSON');
			}
		});
	</script>
	<style type="text/css">
		.alert {
			position: relative;
			margin: 0 auto;
			padding: 10px 10px;
			width: 383px;
		}

		.error {
			background: #B80000;
			color: #fff;
			font-weight: bold;
		}

		.success {
			background: forestgreen;
			color: #fff;
			font-weight: bold;
		}

		.hidden {
			display: none;
		}

		@media screen and (max-width: 480px){
			.alert {
				width: 88%;
			}
		}
	</style>
</head>
<body id="cad-body">
<form id="cad-form" method="POST">
	<fieldset id="cad-field">
		<legend style="text-align: center; padding: 0px 10px;"><img src="<?=HOME?>/assets/cadeado.png" width="40px;" height="40px;" draggable="false" /></legend>
		<div class="alert hidden" id="alert"></div>
		<table style="position: relative; margin: 0 auto;">
			<tr>
				<td><input type="email" name="email" id="email" class="inp-text-cad" placeholder="E-mail" /></td>
			</tr>
			<tr>
				<td><input type="password" name="senha" id="senha" class="inp-text-cad" placeholder="Senha" /></td>
			</tr>
			<tr>
				<td><input type="submit" name="" value="Fazer login" /></td>
			</tr>
		</table>
	</fieldset>
</form>
</body>
</html>