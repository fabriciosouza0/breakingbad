<?php
	include_once('php/config.php');
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no" />
	<meta name="description" content="Site de notícias sobre Breaking Bad" />
	<meta name="keywords" content="Breaking Bad" />
	<meta name="robots" content="index, follow" />
	<meta name="author" content="Fabricio Souza" />
	<link rel="icon" href="<?=HOME?>/logo.ico" type="image/x-icon" />
	<title>Breaking Bad - Home</title>
	<link rel="stylesheet" type="text/css" href="<?=STYLE?>" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script type="text/javascript" src="<?=JS?>/jquery.js"></script>
	<script type="text/javascript" src="<?=JS?>/style.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('article.carregar_mais button').click(function(){
				let init = $('.content .conteudo').length;
				let max  = 3;
				let url  = '<?=HOME?>/php/load.php';

				carregarN(init, max, url, false);
			});

			let carregar_mais = $('.carregar_mais').detach();
			let psInp = false;

			carregarN(0, 7, '<?=HOME?>/php/load.php', false);

			$('#inp-ps').on('keyup',function(e) {
				e.preventDefault();
				let value = $('#inp-ps').val();

				if(value != '') {
					if(psInp == false) carregar_mais = $('.carregar_mais').detach();
					carregarP(value, '<?=HOME?>/php/pesquisa.php');
					psInp = true;
				}else if(psInp){
					carregarN(0, 7, '<?=HOME?>/php/load.php', true);
					psInp = false;
				}

			});

			function carregarN(ini, end, url, clear) {

				let dados  = {init : ini, max : end};

				if(clear){
					$('.content').html('');
				}

				$.ajax({
					type: "POST",
					url: url,
					data: dados,

					success: function(data){
						for(let i = 0; i < data.dados.length; i++) {
							let editavel = false; <?php 
								if(isset($_SESSION['user'])) {
								?>;
								editavel = true;
							<?php
								}
							?>

							let perfilName = data.dados[i].nome_de_usuario;
							
							let dataEn = data.dados[i].data_postagem;
							let dataBr = dataEn.substring(8,10)+'/'+dataEn.substring(5,7)+'/'+dataEn.substring(0,4)+' as '+dataEn.substring(11);

							$('.content').append('<div class="conteudo"><a href="post/'+data.dados[i].slug+'"><div class="backImage" style="background: rgba(0,0,0, 0.7);"><div class="zoom" style="background: url(<?=HOME?>/'+data.dados[i].image_post+') center no-repeat; background-size: cover;"></div></a></div><div class="legend"><span class="nt">'+data.dados[i].descricao+'</span><hr class="divisor-conteudo" /><span class="dt"><a href="<?=HOME?>/perfil/'+perfilName+'"><p><i class="far fa-user"></i> '+perfilName+'</p></a><p><i class="far fa-clock"></i> '+dataBr+'</p></span></div></div>');

								if(editavel) {

								}
							}

							let totalItem = $('.content .conteudo').length;

							if(data.total == totalItem) {
								$('.carregar_mais').hide();
								console.log('Todos os dados carregados');
							}else {
								$('.content').append(carregar_mais);
								$('.carregar_mais').show();
							}

					},

					dataType: "JSON"
					
				});

			}

			function carregarP(v, url) {

				let dados = {value : v};
				let conteudo = '';

				$.post(url, dados, function(data) {
					if(data.dados != null) {
						for(let i = 0; i < data.dados.length; i++) {

							let dataEn = data.dados[i].data_postagem;
							let dataBr = dataEn.substring(8,10)+'/'+dataEn.substring(5,7)+'/'+dataEn.substring(0,4)+' as '+dataEn.substring(11);

							conteudo += '<div class="conteudo"><a href="post/'+data.dados[i].slug+'"><div class="backImage" style="background: rgba(0,0,0, 0.7);"><div class="zoom" style="background: url(<?=HOME?>/'+data.dados[i].image_post+') center no-repeat; background-size: cover;"></div></div><div class="legend"><span class="nt">'+data.dados[i].descricao+'</span><hr class="divisor-conteudo" /><span class="dt"><p><i class="far fa-user"></i>Teste</p><p><i class="far fa-clock"></i> '+dataBr+'</p></span></div></a></div>';

						}
						$('.content').html(conteudo);
					}else {
						$('.content').html('<div class="empty"><center><p>Nenhum conteúdo encontrado sobre "'+v+'".</p></center>');	
					}
					
				}, "JSON");

			}
		});
	</script>
	<style type="text/css">
		.empty {
			position: relative;
			padding: 50px 0px;
			width: 100%;
		}

		.empty p {
			font-weight: bold;
			font-size: 20px;
			color: #d3d3d3;
		}

		main {
			padding-top: 40px;
			padding-bottom: 20px;
		}

		.conteudo {
			margin: 12px auto;
		}

		.backImage {
		    overflow: hidden;
		}

		.backImage .zoom {
			width: 100%;
			height: 100%;
			-webkit-transition: all .2s ease-in-out;
			-moz-transition: all .2s ease-in-out;
			-ms-transition: all .2s ease-in-out;
			-o-transition: all .2s ease-in-out;
			transition: all .2s ease-in-out;
		}

		.backImage:hover .zoom{      
		   -webkit-transform: scale(1.2);
		   -moz-transform: scale(1.2);
		   -ms-transform: scale(1.2);
		   -o-transform: scale(1.2);
		   transform: scale(1.2);
		}

		.content, .aside {
			background: #fff;
		}

		@media screen and (max-width: 980px) {
			main {
				padding-top: 5px;
				padding-bottom: 0px;
			}
			.content, .aside {
				background: transparent;
			}			
		}

		#post-user-name {
			position: absolute;
			padding: 5px;
			bottom: 12px;
			float: left;
			color: #f3f3f3;
		}

		#post-user-name p {
			margin-left: 40px;
			line-height: 2em;
		}

		.perfil-icon {
			position: relative;
			float: left;
			width: 30px;
			height: 30px;
			border-radius: 50%;
			border: 3px solid #fff;
		}
	</style>
</head>
<body>
	<?php

		include 'php/header.php';

	?>
<main>
	<?php

		include 'pages/home.php';

	?>
</main>
<?php

	include 'php/footer.php';

?>
<div class="top">
	<img src="<?=HOME?>/assets/up.png" draggable="false" />
</div>
<div class="modal-container">
	<div class="window">
		<div id="information">
			<button class="close">x</button>
		</div>
	</div>
</div>
</body>
</html>