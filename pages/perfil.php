<?php 

	require_once('../php/connection.php');

	session_start();
	
	if(isset($_GET['user']) && !empty($_GET['user'])) {

		$user = strip_tags(trim($_GET['user']));

		$query = $con->query("SELECT usuario.nome_de_usuario as userName, usuario.nome, usuario.sobreNome, usuario.email, usuario.senha, perfil.banner, perfil.foto, perfil.descricao FROM usuario INNER JOIN perfil ON perfil.usuario_id = usuario.id WHERE usuario.nome_de_usuario = '$user'");
		$asUser = $query->rowCount();

		if($asUser == 0) {
			header('location: /breakingbad');
		}

		$user = $query->fetch();

		$edit = false;

		if(isset($_SESSION['user'])) {
			$userName = $_SESSION['user']['nome_de_usuario'];
			if($userName == $user['userName']) {
				$edit = true;
			}
		}

	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="icon" href="<?=HOME?>/logo.ico" type="image/x-icon" />
	<title>Breaking Bad - <?php echo isset($user['userName'])?$user['userName']:'Error'; ?></title>
	<script type="text/javascript" src="<?=JS?>/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=STYLE?>">
	<style type="text/css">
		header {
			width: 978px;
			margin: 0 auto;
			background: none;
			height: auto;
		}

		main {
			width: 978px;
			margin: 0 auto;
		}

		.banner {
			position: relative;
			margin: 0 auto;
			width: 100%;
			height: 300px;
			background: url(
				<?php 
					if(isset($user['banner'])) {
						if (!empty($user['banner'])) {
							echo HOME.'/perfil_images/banner/'.$user['banner'];
						}else {
							echo HOME.'/assets/banner.png';
						}
					}else {
						echo HOME.'/assets/banner.png';
					} 
				?>) center no-repeat;
			background-size: cover;
		}

		.perfil-image {
			position: absolute;
			left: 20px;
			bottom: 20px;
			width: 120px;
			height: 120px;
			border-radius: 50%;
			border: 7px solid #fff;
			background: #d3d3d3 url(
				<?php 
					if(isset($user['foto'])) {
						if (!empty($user['foto'])) {
							echo HOME.'/perfil_images/foto/'.$user['foto'];
						}else {
							echo HOME.'/assets/cadeado.png';
						}
					}else {
						echo HOME.'/assets/cadeado.png';
					} 
				?>) center no-repeat;
			background-size: cover;
		}

		.perfil-image #user-name {
			position: absolute;
			top: 40px;
			left: 140px;
			padding: 5px 20px;
			border-radius: 5px;
			box-shadow: 5px 5px 14px rgba(0,0,0, 1);
			background: blue;
		}

		.perfil-image #user-name a {
			color: #fff;
		}

		.menu {
			position: relative;
			margin: 0;
			top: 0px;
			border-top-right-radius: 0px;
			border-top-left-radius: 0px;
			width: 100%;
			height: 40px;
			border-bottom-left-radius: 5px;
			border-bottom-right-radius: 5px;
		}

		.menu ul {
			list-style: none;
		}

		.menu ul li {
			float: left;
			padding: 20px;
			min-width: 120px;
			max-width: 120px;
			text-align: center;
			border-right: 1px solid #999;
		}

		.menu ul#list a:last-child li {
			border: 0;
		}

		.perfil-apresentacao {
			position: relative;
			float: left;
			margin-top: 20px;
			width: 30%;
			height: 400px;
			border-radius: 5px;
			border: 1px solid #999;
			background: #fff;
		}

		.content {
			position: relative;
			float: left;
			margin-top: 20px;
			margin-left: 1.5555%;
			width: 68%;
			height: 400px;
			border: 1px solid #999;
			border-radius: 5px;
			background-color: #fff;
		}

		.edit-icon {
			position: absolute;
			top: 10px;
			right: 10px;
			width: 30px;
			cursor: pointer;
		}

		#upload-images-field img#Image {
			padding: 10px;
			max-width: 90%;
			max-height: 300px;
			border: 2px solid black;
		}

		#upload-images-field {
			width: 80%;
			padding: 10px;
			margin: 0 auto;
		}

		#upload-images-field table {
			width: 80%;
			margin: 0 auto;
		}

		#upload-images-field table tr td {
			padding: 5px;
		}		

		#information {
			position: absolute;
			left: 0px;
			top: 0px;
		}

		#config {
			position: absolute;
			top: 4.5px;
			right: 5px;
		}
	</style>
</head>
<body>
	<header>
		<section class="banner">
			<?php 

				if($edit) {
					echo '<img src="'.HOME.'/assets/edit-icon.png" class="edit-icon" id="banner" />';
				}

			?>
			<div class="perfil-image">
				<?php 

					if($edit) {
						echo '<img src="'.HOME.'/assets/edit-icon.png" class="edit-icon" id="perfil_image" />';
					}

				?>
				<span id="user-name">
					<a href="<?=HOME?>/perfil/<?php echo $user['userName']; ?>">
						<?php echo $user['userName']; ?>
					</a>
				</span>
			</div>
		</section>
		<nav class="menu">
			<ul id="list">
				<a href="/breakingbad/perfil/<?php echo $user['userName']; ?>/comentarios"><li>Comentários</li></a>
				<a href="/breakingbad/perfil/<?php echo $user['userName']; ?>/postagens"><li>Postagens</li></a>
				<a href="/breakingbad/perfil/<?php echo $user['userName']; ?>/sobre"><li>Sobre</li></a>
				<a href="/breakingbad/perfil/<?php echo $user['userName']; ?>/reputacao"><li>Reputação</li></a>
				<?php 
					if($edit) {
						echo '<a href="/breakingbad/perfil/'.$user['userName'].'/postar"><li>Postar</li></a>';
						echo '<a href="'.HOME.'/php/logout.php"><li>Log-out</li></a>';
					}
				?>
			</ul>
			<?php
				if($edit) {
					echo '<a href="'.HOME.'/perfil/'.$user['userName'].'/editar" id="config"><img src="'.HOME.'/assets/config.png" width="30px" height="30px;" /></a>';
				} 
			?>
		</nav>
	</header>

	<main>

		<?php include('../php/perfilUrlManager.php'); ?>

	</main>

	<div class="modal-container">
		<div class="window">
			<button class="close">x</button>
			<div id="information" style="position: absolute; width: 100%; height: 100%">
			</div>
		</div>
	</div>
	<?php 
		if($edit) {
	?>
	<script type="text/javascript">
		let _URL = window.URL || window.webkitURL;
		let confirm = false;
		let conteudo;

		let arr_edit_opt = new Array(
				document.getElementsByClassName('edit-icon')[0],
				document.getElementsByClassName('edit-icon')[1],
			);
		let modal = document.querySelector('.modal-container');
		let contentOfModal = $('#information');

		$('body').click(function(e) {
			switch(e.target) {
				case arr_edit_opt[0]:
					let imagePreview = 'Image';
					conteudo = '<form id="form-perfil-images" action="<?=HOME?>/php/perfil_update.php" method="POST" enctype="multipart/form-data" >';
					
					conteudo += '<fieldset id="upload-images-field"><legend style="text-align: center; padding: 0px 10px; width 80%; height: auto;">';
					
					conteudo += '<img src="<?=HOME?>/assets/cadeado.png" width="40px;" height="40px;" draggable="false" /></legend>';
					
					conteudo +='<table>';

					conteudo += '<tr><td align="center"><label for="file"><img src="<?=HOME?>/assets/upload.png" id="Image" style="margin: 0 auto ;" /></label></td></tr>';

					conteudo += '<input type="file" name="banner" id="file" style="display:none;" />';

					conteudo += '<input type="hidden" name="op" value="1" />';

					conteudo += '<tr><td align="center"><input class="submit-btn-green" type="submit" value="enviar" /></fieldset></td></tr></table>';
					
					conteudo += '</form>';

					contentOfModal.html(conteudo);
					_edit();

					$('#form-perfil-images').submit(function(e) {
						if(!confirm) {
							return false;
						}
					});

					$('#file').change(function() {
						validateImage(this, 1336, 720, 1920, 1080, 'Image');
					});
					break;
				case arr_edit_opt[1]:
					conteudo = '<form id="form-perfil-images" action="<?=HOME?>/php/perfil_update.php" method="POST" enctype="multipart/form-data" >';
					
					conteudo += '<fieldset id="upload-images-field"><legend style="text-align: center; padding: 0px 10px;">';
					
					conteudo += '<img src="<?=HOME?>/assets/cadeado.png" width="40px;" height="40px;" draggable="false" /></legend>';
					
					conteudo +='<table>';

					conteudo += '<tr><td align="center"><label for="file"><img src="<?=HOME?>/assets/upload.png" id="Image" style="margin: 0 auto ;" /></label></td></tr>';

					conteudo += '<input type="file" name="perfil_foto" id="file" style="display:none;" />';

					conteudo += '<input type="hidden" name="op" value="2" />';

					conteudo += '<tr><td align="center"><input class="submit-btn-green" type="submit" value="enviar" /></fieldset></td></tr></table>';
					
					conteudo += '</form>';

					contentOfModal.html(conteudo);
					_edit();

					$('#form-perfil-images').submit(function(e) {
						if(!confirm) {
							return false;
						}
					});

					$('#file').change(function() {
						validateImage(this, 133, 133, 610, 400, 'Image');
					});
					break;
			}
		});

		function validateImage(input, minW, minH, maxW, maxH, element) {
			let file, img, w, y, alert;
			alert = $('#cad-form #alert');

			if((file = input.files[0])) {
				img = new Image();
				img.onload = function() {
					w = this.width;
					h = this.height;
					if( w >= minW && w <= maxW && h >= minH && h <= maxH ) {
						console.log('Valida: '+w+'x'+h);
						if(alert.is(':visible')) alert.hide();

						if(alert.hasClass('error')) {
							alert.removeClass('error');
							alert.addClass('success');
						}else {
							alert.addClass('success');
						}

						alert.text('');

						showImage(input, element);
					}else {
						if(alert.hasClass('success')) {
							alert.removeClass('success');
							alert.addClass('error');
						}else {
							alert.addClass('error');
						}

						alert.text('Imagem com dimensões inválidas: Largura =>'+w+' Altura => '+h);
						alert.fadeIn('fast');
					}
				};
				img.src = _URL.createObjectURL(file);
			}
		}

		function showImage(img, element) {
			confirm = true;
		    let reader = new FileReader();
		    let imagem = document.getElementById(element);
		    reader.onload = function(e) {
		      	imagem.src = e.target.result;
		    };
		    reader.readAsDataURL(img.files[0]);	
		}

		function _edit(){
			modal.classList.add('show');
			modal.addEventListener('click', function(e){
				e.stopPropagation();
				if(e.target == modal){
					close(modal);
				}
			});
			document.querySelector('.close').addEventListener('click', close);
		}

		function close(){
			modal.classList.remove('show');
		}
	</script>
<?php } ?>
</body>
</html>